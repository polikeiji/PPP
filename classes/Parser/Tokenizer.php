<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.parser
 */

/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors:  nobody <nobody@localhost>                                  |
// +----------------------------------------------------------------------+
//
// $Id: Tokenizer.php,v 1.13 2007/03/05 05:05:50 cellog Exp $
//

require_once 'Core.php';
require_once 'Token.class.php';
/**
* The tokenizer wrapper for parser - implements the 'standard?' yylex interface
*
* 2 main methods:
*  <ul>
*   <li>constructor, which takes the data to parse 
*     calls php's internal tokenizer, then tidies up the array
*     a little (key=>value) rather than mixed type.</li>
*   <li>advance, which returns true while tokens are available
*       - sets {@link $value}
*       - sets {@link $token}
*   </li>
*   <li>parseError, which returns a string to appear on parser error messages.
*       (could also display some of the code that has an error)
*   </li>
*
* uses a few flags like:
*   - {@link $line} - current line number
*   - {@link $pos} - current token id
*   - {@link $N} - total no. of tokens
* @version    $Id: Tokenizer.php,v 1.13 2007/03/05 05:05:50 cellog Exp $
* @package aowp.parser.parser
*/

class PHP_Parser_Tokenizer {
         
	var $tokenValue;
	
    /**
    * Debugging on/off
    *
    * @var boolean
    * @access public
    */
    var $debug = false;
    /**
    * Tokens - array of all the tokens.
    *
    * @var array
    * @access public
    */
    var $tokens;
    /**
    * Total Number of tokens.
    *
    * @var int
    * @access public
    */
    var $N = 0;
    /**
    * Current line.
    *
    * @var int
    * @access public
    */
    var $line;
    /**
    * Current token position.
    *
    * @var int
    * @access public
    */
    var $pos = -1;
    /**
    * The current token (either a ord(';') or token numer - see php tokenizer.
    *
    * @var int
    * @access public
    */ 
    
    var $token;

    /**
    * The value associated with a token - eg. for T_STRING it's the string 
    *
    * @var string
    * @access public
    */ 
    
    var $value;

    /**
    * The value associated with a token plus preceding whitespace, if any
    *
    * This is only filled if whitespace attachment is turned on, for performance reasons
    * @var string
    * @access public
    */ 
    
    var $valueWithWhitespace;
     
    /**
    * ID of the last Comment Token 
    *
    * @var int
    * @access public
    */ 
    
    var $lastCommentToken; 
     
    /**
    * ID of the last Comment Token 
    *
    * @var int
    * @access public
    */ 
    
    var $lastCommentLine; 

    /**
    * The string of the last Comment Token
    *
    * @var string
    * @access public
    */ 
    
    var $lastComment;

    /**
    * The string of the last Comment Token
    *
    * @var string
    * @access public
    */ 
    
    var $lastParsedComment;
    
    /**
     * String of global variable to search for
     *
     * phpDocumentor-specific usage, extracted from
     * documentation's @global tag
     * @var string
     * @access private
     */
    var $_globalSearch = false;
    
    /**
     * Tokenizing options
     * @access private
     */
    var $_options;
    private $_whitespace;
    private $_trackingWhitespace = 0;
    private $_docParser;
    
    /**
    * Constructor
    *
    * Load the tokenizer - with a string to tokenize.
    * tidies up array, sets vars pos, line, N and tokens
    * 
    * @param   string PHP code to serialize
    * 
    *
    * @return   none
    * @access   public
    */    
    function __construct($data, $docparser = false) 
    {
        $this->_docParser = $docparser;
        $this->tokens = token_get_all($data);
        $this->N = count($this->tokens);
        for ($i=0;$i<$this->N;$i++) {
            if (!is_array($this->tokens[$i])) {
                $this->tokens[$i] = array(ord($this->tokens[$i]),$this->tokens[$i]);
            }
        }
        //最初と最後にダミーを仕込む
       	array_unshift($this->tokens, array(T_INLINE_HTML, ''));
        array_push($this->tokens, array(T_INLINE_HTML, ''));
        $this->N += 2;

        $this->pos = -1;
        $this->line = 1;
        
    }

    function haltLexing()
    {
        $this->pos = $this->N;
    }

    /**
     * Return the whitespace (if any) that preceded the current token
     *
     * @return string
     */
    function getWhitespace()
    {
        return $this->_whitespace;
    }

    /**
     * @param MsgServer_Msg
     */
    function handleMessage($msg)
    {
        if ($msg->getMsg() == 'find global') {
            $this->_setGlobalSearch($msg->getData());
        }
    }
    
    /**
     * @param string
     * @access private
     */
    function _setGlobalSearch($var)
    {
        $this->_globalSearch = $var;
    }

    function trackWhitespace()
    {
        $this->_trackingWhitespace++;
    }

    function stopTrackingWhitespace()
    {
        $this->_trackingWhitespace--;
    }

    /**
     * Compare global variable to search value, to see if we've
     * found a variable that must be documented
     * @param string global variable found in source code
     */
    function globalSearch($var)
    {
        if ($this->_globalSearch) {
            $ret = $var == $this->_globalSearch;
            if ($ret) {
                $this->_globalSearch = false;
            }
            return $ret;
        } else {
            return false;
        }
    }
    
    /**
    * get the last comment block (and reset it)
    *
    * 
    *
    * @return   array  array('comment' => $commmentstring, 'parsed' => $parsed, 'line' => $linenumber)
    * @access   public
    */
    
    function getLastComment()
    {
        $com = $this->lastComment;
        $last = $this->lastParsedComment;
        $tok = $this->lastCommentToken;
        $line = $this->lastCommentLine;
        $this->lastComment = '';
        $this->lastParsedComment = false;
        $this->lastCommentToken = -1;
        $this->lastCommentLine = -1;
       
        return array($com, $last, $line);
    }
    
    /**
     * Helper function for advance(), parses and publishes doc
     * comments as necessary
     * @access private
     */
    function _handleDocumentation()
    {
        $this->lastComment = $this->tokens[$this->pos][1];
        $this->lastCommentToken = $this->tokens[$this->pos][0];
        $this->lastCommentLine = $this->line;
        if ($this->_docParser) {
            try {
                $this->lastParsedComment =
                    $this->_docParser->parse($this->lastComment, $this);
            } catch (Exception $e) {
                $this->lastParsedComment = false;
            }
        }
    }


    /**
    * The main advance call required by the parser 
    *
    * return true if a token is available, false if no more are available.
    * skips stuff that is not a valid token
    * stores lastcomment, lastcommenttoken
    * 
    *
    * @return   boolean - true = have tokens
    * @access   public 
    */
  
    
    function advance() 
    {
		$this->pos++;
        while ($this->pos < $this->N) { 
            
            if ($this->debug) {
                echo token_name($this->tokens[$this->pos][0]). '(' .
                                (PHP_Parser_Core::tokenName(PHP_Parser_Core::$transTable[$this->tokens[$this->pos[0]]])) .
                                ')' ." : {$this->tokens[$this->pos][1]}\n";
            }

            switch ($this->tokens[$this->pos][0]) {
            
            
                // simple ignore tags.
                case T_CLOSE_TAG:
                	//セミコロンを仕込む
                	$this->token = PHP_Parser_Core::$transTable[ord(';')];
                	return true;
                case T_OPEN_TAG_WITH_ECHO:
                    $this->pos++;
                    continue;
                // comments - store for phpdoc
                case T_DOC_COMMENT;
                case T_COMMENT:
                    if (substr($this->tokens[$this->pos][1], 0, 3) == '/**') {
                        $this->lastComment = '';
                        $this->lastCommentToken = -1;
                        $this->lastCommentLine = -1;
                        $this->_handleDocumentation();
                    }
                    $this->line += substr_count ($this->tokens[$this->pos][1], "\n");
                    $this->pos++;
                    continue;
                
                // large 
                case T_OPEN_TAG:
//              case T_INLINE_HTML:
//				case T_ENCAPSED_AND_WHITESPACE:
                case T_WHITESPACE:
                    if ($this->tokens[$this->pos][0] == T_WHITESPACE) {
                        $this->_whitespace = $this->tokens[$this->pos][1];
                    }
                    $this->line += substr_count ($this->tokens[$this->pos][1], "\n");
                    $this->pos++;
                    continue;
                
                //--- begin returnable values--
                
                // everything else!
                default:
                    if ($this->tokens[$this->pos][0] == T_ENCAPSED_AND_WHITESPACE &&
                    	$this->tokens[$this->pos][1] == null) {

                    	$this->line += substr_count ($this->tokens[$this->pos][1], "\n");
	                    $this->pos++;
	                    continue;
                    }
                    $this->line += substr_count ($this->tokens[$this->pos][1], "\n");
                    
                    $this->token = $this->tokens[$this->pos][0];
                    $this->value = $this->tokens[$this->pos][1];
                    $this->token = PHP_Parser_Core::$transTable[$this->token];
                    $this->valueWithWhitespace = $this->_whitespace . $this->value;
                    $this->_whitespace = '';
                    
                    //自分の前後のタグを覚えておく
                    if( $this->tokens[$this->pos][0] == T_INLINE_HTML ){
                    	$nextTagName = null;
                    	if( $this->pos < ($this->N - 1) ) {
	                    	if( $this->tokens[$this->pos + 1][0] == T_OPEN_TAG ){
	                    		$nextTagName = '<?php ';
	                    	}
	                    	else if($this->tokens[$this->pos + 1][0] == T_OPEN_TAG_WITH_ECHO ){
	                    		$nextTagName = '<?= ';
	                    	}
                    	}
                    	$preTagName = null;
                    	if( $this->pos > 0 ){
	                    	if( $this->tokens[$this->pos - 1][0] != T_INLINE_HTML ){
	                    		$preTagName = '?>';	
	                    	}
                    	}
                     	$this->tokenValue = new AOWP_Token( $this->value,
                    										$this->valueWithWhitespace,
                    										$this->line,
                    										array($preTagName, $nextTagName));                  
                    }
                    else{
                    	$this->tokenValue = new AOWP_Token( $this->value,
                    										$this->valueWithWhitespace,
                    										$this->line);
                    }	
                    return true;
            }
        }
        
        //echo "END OF FILE?";
        return false;
        
    }

    function getValue()
    {
		return $this->tokenValue;
    }

    /**
    * return something useful, when a parse error occurs.
    *
    * used to build error messages if the parser fails, and needs to know the line number..
    *
    * @return   string 
    * @access   public 
    */
    function parseError() 
    {
        return "Error at line {$this->line}";
        
    }
    
    public function releaseInstance() {
       	foreach ($this->tokens as $tokenArrayIndex => $tokenArray) {
       		foreach ($tokenArray as $tokenIndex => $token) {
       			$tokenArray[$tokenIndex] = null;
       		}
       		$this->tokens[$tokenArrayIndex] = null;
       	}
    }
}
?>
