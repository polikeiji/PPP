%name PHP_Parser_Core
%declare_class {class PHP_Parser_Core}
	
%syntax_error {
/* ?><?php */
    echo "Syntax Error on line " . $this->lex->line . ": token '" . 
        $this->lex->value . "' while parsing rule:";
    foreach ($this->yystack as $entry) {
        echo $this->tokenName($entry->major) . ' ';
    }
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    if (count($expect) > 5) {
        $expect = array_slice($expect, 0, 5);
        $expect[] = '...';
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN
        . '), expected one of: ' . implode(',', $expect));
}
%include_class {
    static public $transTable = array();
    public $lex;
    public $functions = array();
    public $classes = array();
    //public $interfaces = array();
    //public $includes = array();
    public $globals = array();
    public $root;
    

    function __construct($lex)
    {
        $this->lex = $lex;
        if (!count(self::$transTable)) {
            $start = 240; // start nice and low to be sure
            while (token_name($start) == 'UNKNOWN') {
                $start++;
            }
            $hash = array_flip(self::$yyTokenName);
            $map =
                array(
                    ord(',') => self::COMMA,
                    ord('=') => self::EQUALS,
                    ord('?') => self::QUESTION,
                    ord(':') => self::COLON,
                    ord('|') => self::BAR,
                    ord('^') => self::CARAT,
                    ord('&') => self::AMPERSAND,
                    ord('<') => self::LESSTHAN,
                    ord('>') => self::GREATERTHAN,
                    ord('+') => self::PLUS,
                    ord('-') => self::MINUS,
                    ord('.') => self::DOT,
                    ord('*') => self::TIMES,
                    ord('/') => self::DIVIDE,
                    ord('%') => self::PERCENT,
                    ord('!') => self::EXCLAM,
                    ord('~') => self::TILDE,
                    ord('@') => self::AT,
                    ord('[') => self::LBRACKET,
                    ord('(') => self::LPAREN,
                    ord(')') => self::RPAREN,
                    ord(';') => self::SEMI,
                    ord('{') => self::LCURLY,
                    ord('}') => self::RCURLY,
                    ord('`') => self::BACKQUOTE,
                    ord('$') => self::DOLLAR,
                    ord(']') => self::RBRACKET,
                    ord('"') => self::DOUBLEQUOTE,
                    ord("'") => self::SINGLEQUOTE,
                );
            for ($i = $start; $i < self::YYERRORSYMBOL + $start; $i++) {
                $lt = token_name($i);
                $lt = ($lt == 'T_DOUBLE_COLON') ?  'T_PAAMAYIM_NEKUDOTAYIM' : $lt;
//                echo "$lt has hash? ".$hash[$lt]."\n";
                if (!isset($hash[$lt])) {
                    continue;
                }
                
                //echo "compare $lt with {$tokens[$i]}\n";
                $map[$i] = $hash[$lt];
            }
            //print_r($map);
            // set the map to false if nothing in there.
            self::$transTable = $map;
        }
    }

    public $data;

    //何もしないセマンティックアクションがあると、実行時エラーになるらしい。。
    //何もしないセマンティックアクションではnop()を呼ぶ。
    public function nop(){}
    
        public function releaseInstance() {
    	foreach ($this->classes as $element) {
    		if (is_subclass_of($element, 'AOWP_PHPElement')) {
    			$element->releaseInstance();
    		}
       	}
    	foreach ($this->functions as $element) {
    		if (is_subclass_of($element, 'AOWP_PHPElement')) {
    			$element->releaseInstance();
    		}
       	}
    	foreach ($this->globals as $element) {
    		if (is_subclass_of($element, 'AOWP_PHPElement')) {
    			$element->releaseInstance();
    		}
       	}
       	$this->lex->releaseInstance();
    	if (is_subclass_of($this->root, 'AOWP_PHPElement')) {
    		$this->root->releaseInstance();
    	}
    }
}

%left T_INCLUDE T_INCLUDE_ONCE T_EVAL T_REQUIRE T_REQUIRE_ONCE.
%left COMMA.
%left T_LOGICAL_OR.
%left T_LOGICAL_XOR.
%left T_LOGICAL_AND.
%right T_PRINT.
%left EQUALS T_PLUS_EQUAL T_MINUS_EQUAL T_MUL_EQUAL T_DIV_EQUAL T_CONCAT_EQUAL T_MOD_EQUAL T_AND_EQUAL T_OR_EQUAL T_XOR_EQUAL T_SL_EQUAL T_SR_EQUAL.
%left QUESTION COLON.
%left T_BOOLEAN_OR.
%left T_BOOLEAN_AND.
%left BAR.
%left CARAT.
%left AMPERSAND.
%nonassoc T_IS_EQUAL T_IS_NOT_EQUAL T_IS_IDENTICAL T_IS_NOT_IDENTICAL.
%nonassoc LESSTHAN T_IS_SMALLER_OR_EQUAL GREATERTHAN T_IS_GREATER_OR_EQUAL.
%left T_SL T_SR.
%left PLUS MINUS DOT.
%left TIMES DIVIDE PERCENT.
%right EXCLAM.
%nonassoc T_INSTANCEOF.
%right TILDE T_INC T_DEC T_INT_CAST T_DOUBLE_CAST T_STRING_CAST T_UNICODE_CAST T_BINARY_CAST T_ARRAY_CAST T_OBJECT_CAST T_BOOL_CAST T_UNSET_CAST AT.
%right LBRACKET.
%nonassoc T_NEW T_CLONE.
%left T_ELSEIF.
%left T_ELSE.
%left T_ENDIF.
%right T_STATIC T_ABSTRACT T_FINAL T_PRIVATE T_PROTECTED T_PUBLIC.

%parse_accept {
}

start ::= top_statement_list(B). {
	$this->root = new AOWP_PHPRootElement($this->lex->line, B);
}

top_statement_list(A) ::= top_statement_list(B) top_statement(C). {
	A = B;
	A[] = C;
}
top_statement_list(A) ::= . { A = array(); }

top_statement(A) ::= statement(B). {
	A = B;
	$this->globals[] = &B;
}
top_statement(A) ::= function_declaration_statement(B). {
	A = B;
	$this->functions[] = &B;
}
top_statement(A) ::= class_declaration_statement(B). {
	A = B;
	$this->classes[] = &B;
}
top_statement(A) ::= T_HALT_COMPILER LPAREN RPAREN SEMI. {
	A = new AOWP_PHPHaltCompilerStatementElement($this->lex->line);
}

statement(A) ::= unticked_statement(B). { A = B; }

get_inner_statement_line(A) ::= LCURLY. { A = $this->lex->line; }
unticked_statement(A) ::= get_inner_statement_line(LINE) inner_statement_list(B) RCURLY. { 
	A = new AOWP_PHPInnerStatementElement(LINE, B); 
}

get_if_statement_line(A) ::= T_IF. { A = $this->lex->line; }
unticked_statement(A) ::= get_if_statement_line(LINE) LPAREN expr(E) RPAREN statement(I) elseif_list(EL) else_single(ELL). {
	A = new AOWP_PHPIfStatementElement(LINE, E, I, EL, ELL);
}
unticked_statement(A) ::= get_if_statement_line(LINE) LPAREN expr(E) RPAREN COLON inner_statement_list(I) new_elseif_list(EL) new_else_single(ELL) T_ENDIF SEMI. {
	A = new AOWP_PHPNewIfStatementElement(LINE, E, I, EL, ELL);
}

get_while_statement_line(A) ::= T_WHILE. { A = $this->lex->line; }
unticked_statement(A) ::= get_while_statement_line(LINE) LPAREN expr(B) RPAREN while_statement(C). {
	list($isNewWhile, $val) = C;
	if( $isNewWhile ){
		A = new AOWP_PHPNewWhileStatementElement(LINE, B, $val);
	}
	else{
		A = new AOWP_PHPWhileStatementElement(LINE, B, $val);
	}
}

get_do_statement_line(A) ::= T_DO. { A = $this->lex->line; }
unticked_statement(A) ::= get_do_statement_line(LINE) statement(B) T_WHILE LPAREN expr(C) RPAREN SEMI. {
	A = new AOWP_PHPDoWhileStatementElement(LINE, C, B);
}

get_for_statement_line(A) ::= T_FOR. { A = $this->lex->line; }
unticked_statement(A) ::= get_for_statement_line(LINE)
            LPAREN
                for_expr(B)
            SEMI 
                for_expr(C)
            SEMI
                for_expr(D)
            RPAREN
            for_statement(E). {
	list($isNewFor, $val) = E;
	if($isNewFor){
		A = new AOWP_PHPNewForStatementElement(LINE, B, C, D, $val);
	}
	else{
		A = new AOWP_PHPForStatementElement(LINE, B, C, D, $val);
	}
}

get_switch_statement_line(A) ::= T_SWITCH. { A = $this->lex->line; }
unticked_statement(A) ::= get_switch_statement_line(LINE) LPAREN expr(B) RPAREN switch_case_list(C). {
 A = new AOWP_PHPSwitchStatementElement(LINE, B, C);
}

get_break_statement_line(A) ::= T_BREAK. { A = $this->lex->line; }
unticked_statement(A) ::= get_break_statement_line(LINE) SEMI. {
	A = new AOWP_PHPBreakStatementElement(LINE, null);
}
unticked_statement(A) ::= get_break_statement_line(LINE) expr(B) SEMI. {
	A = new AOWP_PHPBreakStatementElement(LINE, B);
}

get_continue_statement_line(A) ::= T_CONTINUE(A). { A = $this->lex->line; }
unticked_statement(A) ::= get_continue_statement_line(LINE) SEMI.{
	A = new AOWP_PHPContinueStatementElement(LINE, null);
}
unticked_statement(A) ::= get_continue_statement_line(LINE) expr(B) SEMI. {
	A = new AOWP_PHPContinueStatementElement(LINE, B);
}

get_return_statement_line(A) ::= T_RETURN. { A = $this->lex->line; }
unticked_statement(A) ::= get_return_statement_line(LINE) SEMI. {
	A = new AOWP_PHPReturnStatementElement(LINE, null); 
}
unticked_statement(A) ::= get_return_statement_line(LINE) expr_without_variable(B) SEMI. {
	A = new AOWP_PHPReturnStatementElement(LINE, B);
}
unticked_statement(A) ::= get_return_statement_line(LINE) variable(B) SEMI. {
	A = new AOWP_PHPReturnStatementElement(LINE, B);
}

get_global_variable_statement_line(A) ::= T_GLOBAL. { A = $this->lex->line; }
unticked_statement(A) ::= get_global_variable_statement_line(LINE) global_var_list(B) SEMI. {
	A = new AOWP_PHPDefineVariableStatementElement(LINE, 'global', B);
}

get_static_variable_statement_line(A) ::= T_STATIC. { A = $this->lex->line; }
unticked_statement(A) ::= get_static_variable_statement_line(LINE) static_var_list(B) SEMI. {
	A = new AOWP_PHPDefineVariableStatementElement(LINE, 'static', B);
}

get_echo_statement_line(A) ::= T_ECHO. { A = $this->lex->line; }
unticked_statement(A) ::= get_echo_statement_line(LINE) echo_expr_list(B) SEMI. {
	A = new AOWP_PHPEchoStatementElement(LINE, B);
}

unticked_statement(A) ::= T_INLINE_HTML(B). {
	A = new AOWP_PHPInnerHTMLStatementElement($this->lex->line, B);
}

unticked_statement(A) ::= expr(B) SEMI. {
	A = new AOWP_PHPStatementElement($this->lex->line, B);
}

get_use_statement_line(A) ::= T_USE. { A = $this->lex->line; }
unticked_statement(A) ::= get_use_statement_line(LINE) use_filename(B) SEMI. {
	A = new AOWP_PHPUseStatementElement(LINE, B);
}

get_unset_statement_line(A) ::= T_UNSET. { A = $this->lex->line; }
unticked_statement(A) ::= get_unset_statement_line(LINE) LPAREN unset_variables(B) RPAREN SEMI. {
	A = new AOWP_PHPUnsetStatementElement(LINE, B);
}

get_foreach_statement_line(A) ::= T_FOREACH. { A = $this->lex->line; }
unticked_statement(A) ::= get_foreach_statement_line(LINE) LPAREN variable(B) T_AS 
        foreach_variable(C) foreach_optional_arg(D) RPAREN
        foreach_statement(E). {
	list($isNewForeach, $val) = E;
	if( $isNewForeach ){
		A = new AOWP_PHPNewForeachStatementElement(LINE, B, C, D, $val);
	}
	else{
		A = new AOWP_PHPForeachStatementElement(LINE, B, C, D, $val);
	}
}
unticked_statement(A) ::= get_foreach_statement_line(LINE) LPAREN expr_without_variable(B) T_AS 
        variable(C) foreach_optional_arg(D) RPAREN
        foreach_statement(E). {
	list($isNewForeach, $val) = E;
	if( $isNewForeach ){
		A = new AOWP_PHPNewForeachStatementElement(LINE, B, C, D, $val);
	}
	else{
		A = new AOWP_PHPForeachStatementElement(LINE, B, C, D, $val);
	}
}

get_declare_statement_line(A) ::= T_DECLARE. { A = $this->lex->line; }
unticked_statement(A) ::= get_declare_statement_line(LINE) LPAREN declare_list(B) RPAREN declare_statement(C). {
	A = new AOWP_PHPDeclareStatementElement(LINE, B, C);
}

unticked_statement ::= SEMI.

get_try_statement_line(A) ::= T_TRY. { A = $this->lex->line; }
get_catch_statement_line(A) ::= T_CATCH. { A = $this->lex->line; }
unticked_statement(A) ::= get_try_statement_line(LINE) LCURLY inner_statement_list(B) RCURLY
        get_catch_statement_line(LINE2) LPAREN
        fully_qualified_class_name(C)
        T_VARIABLE(D) RPAREN
        LCURLY inner_statement_list(E) RCURLY
        additional_catches(F). {
	$v = new AOWP_PHPVariableElement(LINE2, D);
	$catch = new AOWP_PHPCatchStatementElement(LINE2, C, $v, E);
	array_unshift(F, $catch);
	A = new AOWP_PHPTryCatchStatementElement(LINE, B, F);
}

get_throw_statement_line(A) ::= T_THROW. { A = $this->lex->line; }
unticked_statement(A) ::= get_throw_statement_line(LINE) expr(B) SEMI. {
	A = new AOWP_PHPThrowStatementElement(LINE, B);
}

additional_catches(A) ::= non_empty_additional_catches(B). {
	A = B;
}
additional_catches(A) ::= . {
	A = array();
}

non_empty_additional_catches(A) ::= additional_catch(B). {
	A = array(B);
}
non_empty_additional_catches(A) ::= non_empty_additional_catches(B) additional_catch(C). {
	A = B;
	A[] = C;
}

additional_catch(A) ::= get_catch_statement_line(LINE) LPAREN fully_qualified_class_name(B) T_VARIABLE(C) RPAREN LCURLY inner_statement_list(D) RCURLY. {
	$v = new AOWP_PHPVariableElement(LINE, C);
	A = new AOWP_PHPCatchStatementElement(LINE, B, $v, D);
}

inner_statement_list(A) ::= inner_statement_list(B) inner_statement(C). {
	A = B;
	A[] = C;
}
inner_statement_list(A) ::= . {
	A = array();
}

inner_statement(A) ::= statement(B). {
	A = B;
}
inner_statement(A) ::= function_declaration_statement(B). {
	A = B;
}
inner_statement(A) ::= class_declaration_statement(B). {
	A = B;
}
inner_statement(A) ::= T_HALT_COMPILER LPAREN RPAREN SEMI. {
	A = new AOWP_PHPHaltCompilerStatementElement($this->lex->line);
}

function_declaration_statement(A) ::= unticked_function_declaration_statement(B). {
	A = B;
}

class_declaration_statement(A) ::= unticked_class_declaration_statement(B). {
	A = B;
}

get_func_line(A) ::= T_FUNCTION. { A = $this->lex->line; }
unticked_function_declaration_statement(A) ::=
        get_func_line(LINE) is_reference(ref) T_STRING(funcname) LPAREN parameter_list(params) RPAREN
        LCURLY inner_statement_list(funcinfo) RCURLY. {
	A = new AOWP_PHPFunctionElement(LINE, ref, funcname, params, funcinfo);
}

unticked_class_declaration_statement(A) ::=
        class_entry_type(classtype) T_STRING(C) extends_from(ext)
            implements_list(impl)
            LCURLY
                class_statement_list(cinfo)
            RCURLY. {
	list($line, $type) = classtype;
	A = new AOWP_PHPClassElement($line, $type, C, ext, impl, cinfo);
}
unticked_class_declaration_statement(A) ::=
        interface_entry(LINE) T_STRING(B)
            interface_extends_list(C)
            LCURLY
                class_statement_list(D)
            RCURLY. {
	A = new AOWP_PHPInterfaceElement(LINE, B, C, D);
}

class_entry_type(A) ::= T_CLASS. { A = array($this->lex->line, ""); }
class_entry_type(A) ::= T_ABSTRACT T_CLASS. { A = array($this->lex->line, "abstract"); }
class_entry_type(A) ::= T_FINAL T_CLASS. { A = array($this->lex->line, "final"); }

extends_from(A) ::= T_EXTENDS fully_qualified_class_name(B). { A = B; }
extends_from(A) ::= . { A = null; }

interface_entry(A) ::= T_INTERFACE. { A = $this->lex->line; }

interface_extends_list(A) ::= T_EXTENDS interface_list(B). { A = B; }
interface_extends_list(A) ::= . { A = array(); }

implements_list(A) ::= . { A = array(); }
implements_list(A) ::= T_IMPLEMENTS interface_list(B). { A = B; }

interface_list(A) ::= fully_qualified_class_name(B). { A = array(B); }
interface_list(A) ::= interface_list(B) COMMA fully_qualified_class_name(C). { 
	A = B;
	A[] = C;
}

expr(A) ::= r_variable(B). { A = B; }
expr(A) ::= expr_without_variable(B). { A = B; }

get_list_line(A) ::= T_LIST. { A = $this->lex->line; }
expr_without_variable(A) ::= get_list_line(LINE) LPAREN assignment_list(B) RPAREN EQUALS expr(C). {
	$list_element = new AOWP_PHPListElement(LINE, B);
	A = new AOWP_PHPEqualExprElement(LINE, $list_element, '=', C);
}
expr_without_variable(A) ::= variable(VAR) EQUALS expr(E). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, VAR, '=', E);
}
expr_without_variable(A) ::= variable(VAR) EQUALS AMPERSAND variable(E).{
	$amp = new AOWP_PHPAmpersandExprElement($this->lex->line, E);
	A = new AOWP_PHPEqualExprElement($this->lex->line, VAR, '=', $amp);
}

expr_without_variable(A) ::= variable(VAR) EQUALS AMPERSAND T_NEW class_name_reference(CL) ctor_arguments(ARGS). {
	$newExpr = new AOWP_PHPNewExprElement($this->lex->line, CL, ARGS);
	$ampExpr = new AOWP_PHPAmpersandExprElement($this->lex->line, $newExpr);
	A = new AOWP_PHPEqualExprElement($this->lex->line, VAR, '=', $ampExpr);
}

get_new_expr_line(A) ::= T_NEW. { A = $this->lex->line; }
expr_without_variable(A) ::= get_new_expr_line(LINE) class_name_reference(B) ctor_arguments(C). {
	A = new AOWP_PHPNewExprElement(LINE, B, C);
}

get_clone_expr_line(A) ::= T_CLONE. { A = $this->lex->line; }
expr_without_variable(A) ::= get_clone_expr_line(LINE) expr(B). {
	A = new AOWP_PHPCloneExprElement(LINE, B);
}
expr_without_variable(A) ::= variable(B) T_PLUS_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '+=', C);
}
expr_without_variable(A) ::= variable(B) T_MINUS_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '-=', C);
}

expr_without_variable(A) ::= variable(B) T_MUL_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '*=', C);
}

expr_without_variable(A) ::= variable(B) T_DIV_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '/=', C);
}

expr_without_variable(A) ::= variable(B) T_CONCAT_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '.=', C);
}

expr_without_variable(A) ::= variable(B) T_MOD_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '%=', C);
}

expr_without_variable(A) ::= variable(B) T_AND_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '&=', C);
}

expr_without_variable(A) ::= variable(B) T_OR_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '|=', C);
}

expr_without_variable(A) ::= variable(B) T_XOR_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '^=', C);
}

expr_without_variable(A) ::= variable(B) T_SL_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '<<=', C);
}

expr_without_variable(A) ::= variable(B) T_SR_EQUAL expr(C). {
	A = new AOWP_PHPEqualExprElement($this->lex->line, B, '>>=', C);
}

expr_without_variable(A) ::= rw_variable(B) T_INC. {
	A = new AOWP_PHPPostfixMonadicOperatorExprElement($this->lex->line, B, '++');
}
expr_without_variable(A) ::= T_INC rw_variable(B). {
	A = new AOWP_PHPPrefixMonadicOperatorExprElement($this->lex->line, '++', B);
}
expr_without_variable(A) ::= rw_variable(B) T_DEC. {
	A = new AOWP_PHPPostfixMonadicOperatorExprElement($this->lex->line, B, '--');
}
expr_without_variable(A) ::= T_DEC rw_variable(B). {
	A = new AOWP_PHPPrefixMonadicOperatorExprElement($this->lex->line, '--', B);
}
expr_without_variable(A) ::= expr(B) T_BOOLEAN_OR expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '||', C);
}
expr_without_variable(A) ::= expr(B) T_BOOLEAN_AND expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '&&', C);
}
expr_without_variable(A) ::= expr(B) T_LOGICAL_OR expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, 'or', C);
}
expr_without_variable(A) ::= expr(B) T_LOGICAL_AND expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, 'and', C);
}
expr_without_variable(A) ::= expr(B) T_LOGICAL_XOR expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, 'xor', C);
}
expr_without_variable(A) ::= expr(B) BAR expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '|', C);
}
expr_without_variable(A) ::= expr(B) AMPERSAND expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '&', C);
}
expr_without_variable(A) ::= expr(B) CARAT expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '^', C);
}
expr_without_variable(A) ::= expr(B) DOT expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '.', C);
}
expr_without_variable(A) ::= expr(B) PLUS expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '+', C);
}
expr_without_variable(A) ::= expr(B) MINUS expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '-', C);
}
expr_without_variable(A) ::= expr(B) TIMES expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '*', C);
}
expr_without_variable(A) ::= expr(B) DIVIDE expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '/', C);
}
expr_without_variable(A) ::= expr(B) PERCENT expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '%', C);
}
expr_without_variable(A) ::= expr(B) T_SL expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '<<', C);
}
expr_without_variable(A) ::= expr(B) T_SR expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '>>', C);
}
expr_without_variable(A) ::= PLUS expr(B). {
	A = new AOWP_PHPPrefixMonadicOperatorExprElement($this->lex->line, '+', B);
}
expr_without_variable(A) ::= MINUS expr(B). {
	A = new AOWP_PHPPrefixMonadicOperatorExprElement($this->lex->line, '-', B);
}
expr_without_variable(A) ::= EXCLAM expr(B). {
	A = new AOWP_PHPPrefixMonadicOperatorExprElement($this->lex->line, '!', B);
}
expr_without_variable(A) ::= TILDE expr(B). {
	A = new AOWP_PHPPrefixMonadicOperatorExprElement($this->lex->line, '~', B);
}
expr_without_variable(A) ::= expr(B) T_IS_IDENTICAL expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '===', C);
}
expr_without_variable(A) ::= expr(B) T_IS_NOT_IDENTICAL expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '!==', C);
}
expr_without_variable(A) ::= expr(B) T_IS_EQUAL expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '==', C);
}
expr_without_variable(A) ::= expr(B) T_IS_NOT_EQUAL expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '!=', C);
}
expr_without_variable(A) ::= expr(B) LESSTHAN expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '<', C);
}
expr_without_variable(A) ::= expr(B) T_IS_SMALLER_OR_EQUAL expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '<=', C);
}
expr_without_variable(A) ::= expr(B) GREATERTHAN expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '>', C);
}
expr_without_variable(A) ::= expr(B) T_IS_GREATER_OR_EQUAL expr(C). {
	A = new AOWP_PHPBinaryOperatorExprElement($this->lex->line, B, '>=', C);
}
expr_without_variable(A) ::= expr(B) T_INSTANCEOF class_name_reference(CL). {
	A = new AOWP_PHPInstanceofExprElement($this->lex->line, B, CL);
}
expr_without_variable(A) ::= LPAREN expr(B) RPAREN. {
	A = new AOWP_PHPBracketExprElement($this->lex->line, B);
}
expr_without_variable(A) ::= expr(B) QUESTION
        expr(C) COLON
        expr(D). {
	A = new AOWP_PHPQuestionExprElement($this->lex->line, B, C, D);
}
expr_without_variable(A) ::= internal_functions_in_yacc(B). {
	A = B;
}
expr_without_variable(A) ::= T_INT_CAST expr(B). {
	A = new AOWP_PHPCastExprElement($this->lex->line, 'int', B);
}
expr_without_variable(A) ::= T_DOUBLE_CAST expr(B). {
	A = new AOWP_PHPCastExprElement($this->lex->line, 'double', B);
}
expr_without_variable(A) ::= T_STRING_CAST expr(B). {
	A = new AOWP_PHPCastExprElement($this->lex->line, 'string', B);
}
expr_without_variable(A) ::= T_ARRAY_CAST expr(B). {
	A = new AOWP_PHPCastExprElement($this->lex->line, 'array', B);
}
expr_without_variable(A) ::= T_OBJECT_CAST expr(B). {
	A = new AOWP_PHPCastExprElement($this->lex->line, 'object', B);
}
expr_without_variable(A) ::= T_BINARY_CAST expr(B). {
	A = new AOWP_PHPCastExprElement($this->lex->line, 'binary', B);
}
expr_without_variable(A) ::= T_BOOL_CAST expr(B). {
	A = new AOWP_PHPCastExprElement($this->lex->line, 'bool', B);
}
expr_without_variable(A) ::= T_UNSET_CAST expr(B). {
	A = new AOWP_PHPCastExprElement($this->lex->line, 'unset', B);
}
expr_without_variable(A) ::= T_EXIT exit_expr(B). {
	A = new AOWP_PHPExitExprElement($this->lex->line, B);
}
expr_without_variable(A) ::= AT expr(B). {
	A = new AOWP_PHPPrefixMonadicOperatorExprElement($this->lex->line, '@', B);
}
expr_without_variable(A) ::= scalar(B). {
	A = new AOWP_PHPScalarExprElement($this->lex->line, B);
}
expr_without_variable(A) ::= expr_without_variable_t_array(LINE) LPAREN array_pair_list(B) RPAREN. {
	A = new AOWP_PHPArrayElement(LINE, B);
}
expr_without_variable(A) ::= BACKQUOTE encaps_list(B) BACKQUOTE. {
	A = new AOWP_PHPQuoteExprElement($this->lex->line, 'backquote', B);
}
expr_without_variable(A) ::= T_PRINT expr(B). {
	A = new AOWP_PHPPrintExprElement($this->lex->line, B);
}

expr_without_variable_t_array(A) ::= T_ARRAY. { A = $this->lex->line; }

exit_expr(A) ::= LPAREN RPAREN. { A = null; }
exit_expr(A) ::= LPAREN expr(B) RPAREN. { A = B; }
exit_expr(A) ::= . { A = null; }

common_scalar(A) ::=
        T_LNUMBER
       |T_DNUMBER
       |T_CONSTANT_ENCAPSED_STRING
       |T_LINE
       |T_FILE
       |T_CLASS_C
       |T_METHOD_C
       |T_FUNC_C(B). {
	A = B;
}

/* compile-time evaluated scalars */
static_scalar(A) ::= common_scalar(B). { A = B; }
static_scalar(A) ::= T_STRING(B). { A = B; }
static_scalar(A) ::= PLUS static_scalar(B). { A = '+' . B; }
static_scalar(A) ::= MINUS static_scalar(B). { A = '-' . B; }
static_scalar(A) ::= static_scalar_t_array(B) LPAREN(C) static_array_pair_list(D) RPAREN(E). {
	A = new AOWP_PHPArrayElement(B, D);
}
static_scalar(A) ::= static_class_constant(B). { A = B; }

static_scalar_t_array(A) ::= T_ARRAY(B). { A = $this->lex->line; }

static_array_pair_list(A) ::= non_empty_static_array_pair_list(B). { A = B; }
static_array_pair_list(A) ::= non_empty_static_array_pair_list(B) COMMA(C). { A = B; }
static_array_pair_list(A) ::= . { A = array(); }

non_empty_static_array_pair_list(A) ::= non_empty_static_array_pair_list(B) COMMA(C) static_scalar(D) T_DOUBLE_ARROW(E) static_scalar(F). {
	A = B;
	$e1 = new AOWP_PHPScalarExprElement($this->lex->line, D);
	$e2 = new AOWP_PHPScalarExprElement($this->lex->line, F);
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, $e1, $e2);
}
non_empty_static_array_pair_list(A) ::= non_empty_static_array_pair_list(B) COMMA(C) static_scalar(D). {
	A = B;
	$e1 = new AOWP_PHPScalarExprElement($this->lex->line, D);
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, null, $e1);
}
non_empty_static_array_pair_list(A) ::= static_scalar(B) T_DOUBLE_ARROW(C) static_scalar(D). {
	A = array();
	$e1 = new AOWP_PHPScalarExprElement($this->lex->line, B);
	$e2 = new AOWP_PHPScalarExprElement($this->lex->line, D);
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, $e1, $e2);
}
non_empty_static_array_pair_list(A) ::= static_scalar(B). {
	A = array();
	$e1 = new AOWP_PHPScalarExprElement($this->lex->line, B);
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, null, $e1);
}

static_class_constant(A) ::= T_STRING(B) T_PAAMAYIM_NEKUDOTAYIM T_STRING(C). {
	A = new AOWP_PHPClassConstVariableRefElement($this->lex->line, B, C);
}

foreach_optional_arg(A) ::= T_DOUBLE_ARROW foreach_variable(B). { A = B; }
foreach_optional_arg(A) ::= . { A = null; }

foreach_variable(A) ::= w_variable(B). { A = B; }
foreach_variable(A) ::= AMPERSAND w_variable(B). {
	A = new AOWP_PHPAmpersandExprElement($this->lex->line, B);
}

for_statement(A) ::= statement(B). {
	if( is_array(B) ){
		$a = B;
	}
	else{
		$a = array();
		$a[] = B;
	}
	A = array(false, $a); 
}
for_statement(A) ::= COLON inner_statement_list(B) T_ENDFOR SEMI. {
	A = array(true, B); 
}

foreach_statement(A) ::= statement(B). {
	if( is_array(B) ){
		$a = B;
	}
	else{
		$a = array();
		$a[] = B;
	}
	A = array(false, $a);
}
foreach_statement(A) ::= COLON inner_statement_list(B) T_ENDFOREACH SEMI. {
	A = array(true, B);
}

declare_statement(A) ::= statement(B). {
	A = array();
	A = B;
}
declare_statement(A) ::= COLON inner_statement_list(B) T_ENDDECLARE SEMI. {
	A = B;
}

declare_list(A) ::= T_STRING(B) EQUALS static_scalar(C). {
	A = array();
	A[] = new AOWP_PHPEqualExprElement($this->lex->line, B, '=', C);
}
declare_list(A) ::= declare_list(DEC) COMMA T_STRING(B) EQUALS static_scalar(C). {
	A = DEC;
	A[] = new AOWP_PHPEqualExprElement($this->lex->line, B, '=', C);
}

switch_case_list(A) ::= LCURLY case_list(B) RCURLY. { A = B; }
switch_case_list(A) ::= LCURLY SEMI case_list(B) RCURLY. { A = B; }
switch_case_list(A) ::= COLON case_list(B) T_ENDSWITCH SEMI. { A = B; }
switch_case_list(A) ::= COLON SEMI case_list(B) T_ENDSWITCH SEMI. { A = B; }

case_list(A) ::= case_list(LIST) T_CASE expr(B) case_separator(LINE) inner_statement_list(C). {
	A = LIST;
	A[] = new AOWP_PHPCaseStatementElement(LINE, B, C);
}
case_list(A) ::= case_list(LIST) T_DEFAULT case_separator(LINE) inner_statement_list(B). {
	A = LIST;
	A[] = new AOWP_PHPCaseStatementElement(LINE, 'default', B);
}
case_list(A) ::= . {
	A = array();
}

case_separator(A) ::= COLON|SEMI. { A = $this->lex->line; }

while_statement(A) ::= statement(B). {
	if( is_array(B) ){
		$a = B;
	}
	else{
		$a = array();
		$a[] = B;
	}
	A = array(false, $a);
}
while_statement(A) ::= COLON inner_statement_list(B) T_ENDWHILE SEMI. { 
	A = array(true, B); 
}

elseif_list(A) ::= elseif_list(B) T_ELSEIF LPAREN expr(C) RPAREN statement(D). {
	A = B;
	A[] = new AOWP_PHPElseIfStatementElement($this->lex->line, C, array(D));
}
elseif_list(A) ::= elseif_list(B) T_ELSE T_IF LPAREN expr(C) RPAREN statement(D). {
	A = B;
	A[] = new AOWP_PHPElseIfStatementElement($this->lex->line, C, array(D));
}
elseif_list(A) ::= . {
	A = array();
}

new_elseif_list(A) ::= new_elseif_list(B) T_ELSEIF LPAREN expr(C) RPAREN COLON inner_statement_list(D) . {
	A = B;
	A[] = new AOWP_PHPNewElseIfStatementElement($this->lex->line, C, D);
}
new_elseif_list(A) ::= . {
	A = array();
}

else_single(A) ::= T_ELSE statement(B). {
	A = array(B);
}
else_single(A) ::= . {
	A = array();
}

new_else_single(A) ::= T_ELSE COLON inner_statement_list(B). {
	A = new AOWP_PHPNewElseStatementElement($this->lex->line, B);
}
new_else_single(A) ::= . {
	A = null;
}

parameter_list(A) ::= non_empty_parameter_list(B). { A = B; }
parameter_list(A) ::= . { A = array(); }

non_empty_parameter_list(A) ::= optional_class_type(T) T_VARIABLE(V). {
	$v = new AOWP_PHPVariableElement($this->lex->line, V);
	A = array();
	A[] = new AOWP_PHPParamaterElement($this->lex->line, T, $v, null);
}
non_empty_parameter_list(A) ::= optional_class_type(T) AMPERSAND T_VARIABLE(V). {
	A = array();
	$v1 = new AOWP_PHPVariableElement($this->lex->line, V);
	$v = new AOWP_PHPAmpersandExprElement($this->lex->line, $v1);
	A[] = new AOWP_PHPParamaterElement($this->lex->line, T, $v, null);
}
non_empty_parameter_list(A) ::= optional_class_type(T) AMPERSAND T_VARIABLE(V) EQUALS static_scalar(D). {
	A = array();
	$v1 = new AOWP_PHPVariableElement($this->lex->line, V);
	$v = new AOWP_PHPAmpersandExprElement($this->lex->line, $v1);
	A[] = new AOWP_PHPParamaterElement($this->lex->line, T, $v, D);
}
non_empty_parameter_list(A) ::= optional_class_type(T) T_VARIABLE(V) EQUALS static_scalar(D). {
	A = array();
	$v1 = new AOWP_PHPVariableElement($this->lex->line, V);
	A[] = new AOWP_PHPParamaterElement($this->lex->line, T, $v1, D);
}
non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) T_VARIABLE(V). {
	A = list;
	$v1 = new AOWP_PHPVariableElement($this->lex->line, V);
	A[] = new AOWP_PHPParamaterElement($this->lex->line, T, $v1, null);
}
non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) AMPERSAND T_VARIABLE(V). {
	A = list;
	$v1 = new AOWP_PHPVariableElement($this->lex->line, V);
	$v = new AOWP_PHPAmpersandExprElement($this->lex->line, $v1);
	A[] = new AOWP_PHPParamaterElement($this->lex->line, T, $v, null);
}
non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) AMPERSAND T_VARIABLE(V) EQUALS static_scalar(D). {
	A = list;
	$v1 = new AOWP_PHPVariableElement($this->lex->line, V);
	$v = new AOWP_PHPAmpersandExprElement($this->lex->line, $v1);
	A[] = new AOWP_PHPParamaterElement($this->lex->line, T, $v, D);
}
non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) T_VARIABLE(V) EQUALS static_scalar(D). {
	A = list;
	$v1 = new AOWP_PHPVariableElement($this->lex->line, V);
	A[] = new AOWP_PHPParamaterElement($this->lex->line, T, $v1, D);
}


optional_class_type(A) ::= T_STRING|T_ARRAY(B). { A = B; }
optional_class_type(A) ::= . { A = null; }

function_call_parameter_list(A) ::= non_empty_function_call_parameter_list(B). { A = B; }
function_call_parameter_list(A) ::= . { A = array(); }

non_empty_function_call_parameter_list(A) ::= expr_without_variable(B). {
	A = array();
	A[] = new AOWP_PHPArgumentElement($this->lex->line, B);
}
non_empty_function_call_parameter_list(A) ::= variable(B). {
	A = array();
	A[] = new AOWP_PHPArgumentElement($this->lex->line, B);
}
non_empty_function_call_parameter_list(A) ::= AMPERSAND w_variable(B). {
	A = array();
	$v = new AOWP_PHPAmpersandExprElement($this->lex->line, B);
	A[] = new AOWP_PHPArgumentElement($this->lex->line, $v);
}
non_empty_function_call_parameter_list(A) ::= non_empty_function_call_parameter_list(LIST) COMMA expr_without_variable(B). {
	A = LIST;
	A[] = new AOWP_PHPArgumentElement($this->lex->line, B);
}
non_empty_function_call_parameter_list(A) ::= non_empty_function_call_parameter_list(LIST) COMMA variable(B). {
	A = LIST;
	A[] = new AOWP_PHPArgumentElement($this->lex->line, B);
}
non_empty_function_call_parameter_list(A) ::= non_empty_function_call_parameter_list(LIST) COMMA AMPERSAND w_variable(B). {
	A = LIST;
	$v = new AOWP_PHPAmpersandExprElement($this->lex->line, B);
	A[] = new AOWP_PHPArgumentElement($this->lex->line, $v);
}

global_var_list(A) ::= global_var_list(B) COMMA global_var(C). {
	A = B;
	A[] = C;
}
global_var_list(A) ::= global_var(B). {
	A = array();
	A[] = B;
}

global_var(A) ::= T_VARIABLE(B). {
	A = new AOWP_PHPVariableElement($this->lex->line, B);
}
global_var(A) ::= DOLLAR r_variable(B). {
	A = new AOWP_PHPIndirectVariableElement($this->lex->line, array('$'), B);
}
global_var(A) ::= DOLLAR LCURLY expr(B) RCURLY.{
	A = new AOWP_PHPCompoundVariableElement($this->lex->line, '${', B);
}


static_var_list(A) ::= static_var_list(B) COMMA T_VARIABLE(C). {
	A = B;
	A[] = C;
}
static_var_list(A) ::= static_var_list(B) COMMA T_VARIABLE(C) EQUALS static_scalar(D). {
	A = B;
	$v1 = new AOWP_PHPVariableElement($this->lex->line, C);
	A[] = new AOWP_PHPEqualExprElement($this->lex->line, $v1, '=', D);
}
static_var_list(A) ::= T_VARIABLE(B). {
	A = array();
	A[] = new AOWP_PHPVariableElement($this->lex->line, B);
}
static_var_list(A) ::= T_VARIABLE(B) EQUALS static_scalar(C). {
	A = array();
	$v1 = new AOWP_PHPVariableElement($this->lex->line, B);
	A[] = new AOWP_PHPEqualExprElement($this->lex->line, $v1, '=', C);
}

class_statement_list(A) ::= class_statement_list(list) class_statement(B). {
	A = list;
	A[] = B;
}
class_statement_list(A) ::= . {
	A = array();
}

class_statement(A) ::= variable_modifiers(mod) class_variable_declaration(B) SEMI. {
	A = new AOWP_PHPClassVariableElement($this->lex->line, mod, B);
}
class_statement(A) ::= class_constant_declaration(B) SEMI. {
	A = new AOWP_PHPDefineConstantVariableStatementElement($this->lex->line, B);
}
get_method_line(A) ::= T_FUNCTION. { A = $this->lex->line; }
class_statement(A) ::= method_modifiers(mod) get_method_line(LINE) is_reference(IS_REF) T_STRING(B) LPAREN parameter_list(params) RPAREN method_body(M). {
	A = new AOWP_PHPMethodElement(LINE, mod, IS_REF, B, params, M);
}

method_body(A) ::= SEMI. /* abstract method */ { A = null; }
method_body(A) ::= LCURLY inner_statement_list(B) RCURLY. { A = B; }

variable_modifiers(A) ::= non_empty_member_modifiers(B). { A = B; }
variable_modifiers(A) ::= T_VAR. {
	A = array();
	A[] = 'var';
}

method_modifiers(A) ::= non_empty_member_modifiers(B). { A = B; }
method_modifiers(A) ::= . { A = array(); }

non_empty_member_modifiers(A) ::= member_modifier(B). {
	A = array();
	A[] = B;
}
non_empty_member_modifiers(A) ::= non_empty_member_modifiers(mod) member_modifier(B). {
	A = mod;
	A[] = B;
}

member_modifier(A) ::= T_PUBLIC|T_PROTECTED|T_PRIVATE|T_STATIC|T_ABSTRACT|T_FINAL(B). { A = B; }

class_variable_declaration(A) ::= class_variable_declaration(LIST) COMMA T_VARIABLE(var). {
	A = LIST;
	A[] = new AOWP_PHPVariableElement($this->lex->line, var);
}
class_variable_declaration(A) ::= class_variable_declaration(LIST) COMMA T_VARIABLE(var) EQUALS static_scalar(val). {
	A = LIST;
	$v = new AOWP_PHPVariableElement($this->lex->line, var);
	A[] = new AOWP_PHPEqualExprElement($this->lex->line, $v, '=', val);
}
class_variable_declaration(A) ::= T_VARIABLE(B). {
	A = array();
	A[] = new AOWP_PHPVariableElement($this->lex->line, B);
}
class_variable_declaration(A) ::= T_VARIABLE(var) EQUALS static_scalar(val). {
	A = array();
	$v = new AOWP_PHPVariableElement($this->lex->line, var);
	A[] = new AOWP_PHPEqualExprElement($this->lex->line, $v, '=', val);
}
class_variable_declaration(A) ::= T_VARIABLE(var) EQUALS function_call(func_call). {
	A = array();
	A[] = new AOWP_PHPEqualExprElement($this->lex->line, func_call, '=', val);
}

class_constant_declaration(A) ::= class_constant_declaration(LIST) COMMA T_STRING(n) EQUALS static_scalar(v). {
	A = LIST;
	A[] = new AOWP_PHPDefineConstantVariableElement($this->lex->line, n, v);
}
class_constant_declaration(A) ::= T_CONST T_STRING(n) EQUALS static_scalar(v). {
	A = array();
	A[] = new AOWP_PHPDefineConstantVariableElement($this->lex->line, n, v);
}

echo_expr_list(A) ::= echo_expr_list(B) COMMA expr(C). {
	A = B;
	A[] = C;
}
echo_expr_list(A) ::= expr(B). {
	A = array();
	A[] = B;
}

unset_variables(A) ::= unset_variable(B). {
	A = array();
	A[] = B;
}
unset_variables(A) ::= unset_variables(B) COMMA unset_variable(C). {
	A = B;
	A[] = C;
}

unset_variable(A) ::= variable(B). { A = B; }

use_filename(A) ::= T_CONSTANT_ENCAPSED_STRING(B). { A = B; }
use_filename(A) ::= LPAREN T_CONSTANT_ENCAPSED_STRING(B) RPAREN. { A = B; }

r_variable(A) ::= variable(B). { A = B; }

w_variable(A) ::= variable(B). { A = B; }

rw_variable(A) ::= variable(B). { A = B; }

variable(A) ::= base_variable_with_function_calls(BASE) T_OBJECT_OPERATOR object_property(PROP) method_or_not(METHOD) variable_properties(VARP). {
	$p = new AOWP_PHPObjectPropertyElement($this->lex->line, PROP, METHOD);
	array_unshift(VARP, $p);
	A = new AOWP_PHPObjectOperatorElement($this->lex->line, BASE, VARP);
}
variable(A) ::= base_variable_with_function_calls(B). { A = B; }

variable_properties(A) ::= variable_properties(B) variable_property(C).{
	A = B;
	A[] = C;
}
variable_properties(A) ::= . {
	A = array();
}

variable_property(A) ::= T_OBJECT_OPERATOR object_property(B) method_or_not(C). {
	A = new AOWP_PHPObjectPropertyElement($this->lex->line, B, C);
}

method_or_not(A) ::= LPAREN function_call_parameter_list(B) RPAREN. { A = B; }
method_or_not(A) ::= . { A = null; }

variable_without_objects(A) ::= reference_variable(B). { A = B; }
variable_without_objects(A) ::= simple_indirect_reference(I) reference_variable(B). {
	A = new AOWP_PHPIndirectVariableElement($this->lex->line, I, B);
}

static_member(A) ::= fully_qualified_class_name(CLASS) T_PAAMAYIM_NEKUDOTAYIM variable_without_objects(VAR). {
	A = new AOWP_PHPStaticMemberRefElement($this->lex->line, CLASS, VAR);
}

base_variable_with_function_calls(A) ::= base_variable(B). { A = B; }
base_variable_with_function_calls(A) ::= function_call(B). { A = B; }

base_variable(A) ::= reference_variable(B). { A = B; }
base_variable(A) ::= simple_indirect_reference(I) reference_variable(B). {
	A = new AOWP_PHPIndirectVariableElement($this->lex->line, I, B);
}
base_variable(A) ::= static_member(B). { A = B; }
    
reference_variable(A) ::= reference_variable(REF) LBRACKET dim_offset(DIM) RBRACKET. {
	A = new AOWP_PHPReferenceVariableElement($this->lex->line, REF, DIM);
}
reference_variable(A) ::= reference_variable(REF) LCURLY expr(DIM) RCURLY. {
	A = new AOWP_PHPReferenceVariableElement($this->lex->line, REF, DIM);
}
reference_variable(A) ::= compound_variable(B). { A = B; }

compound_variable(A) ::= T_VARIABLE(B). {
	A = new AOWP_PHPVariableElement($this->lex->line, B);
}
compound_variable(A) ::= DOLLAR LCURLY expr(B) RCURLY. {
	A = new AOWP_PHPCompoundVariableElement($this->lex->line, '${', B);
}

dim_offset(A) ::= expr(B). { A = B; }
dim_offset(A) ::= . { A = null; }

object_property(A) ::= object_dim_list(B). { A = B; }
object_property(A) ::= variable_without_objects(B). { A = B; }

object_dim_list(A) ::= object_dim_list(LIST) LBRACKET dim_offset(B) RBRACKET. {
	A = new AOWP_PHPReferenceVariableElement($this->lex->line, LIST, B);
}
object_dim_list(A) ::= object_dim_list(LIST) LCURLY expr(B) RCURLY. {
	A = new AOWP_PHPReferenceVariableElement($this->lex->line, LIST, B);
}
object_dim_list(A) ::= variable_name(B). { A = B; }

variable_name(A) ::= T_STRING(B). { A = B; }
variable_name(A) ::= LCURLY expr(B) RCURLY. {
	A = new AOWP_PHPCompoundVariableElement($this->lex->line, '{', B);
}

simple_indirect_reference(A) ::= DOLLAR. {
	A = array();
	A[] = '$';
}
simple_indirect_reference(A) ::= simple_indirect_reference(B) DOLLAR. {
	A = B;
	A[] = '$';
}

assignment_list(A) ::= assignment_list(B) COMMA assignment_list_element(C). {
	A = B;
	A[] = C;
}
assignment_list(A) ::= assignment_list_element(B). {
	A = array(B);
}

assignment_list_element(A) ::= variable(B). {
	A = B;
}
assignment_list_element(A) ::= get_list_line(LINE) LPAREN assignment_list(B) RPAREN. {
	A = new AOWP_PHPListElement(LINE, B);
}
assignment_list_element(A) ::= . {
	A = array();
}

array_pair_list(A) ::= non_empty_array_pair_list(B) possible_comma(C). { A = B; }
array_pair_list(A) ::= . { A = array(); }

non_empty_array_pair_list(A) ::= expr(B) T_DOUBLE_ARROW AMPERSAND w_variable(C). {
	A = array();
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, B, C);
}
non_empty_array_pair_list(A) ::= expr(B). {
	A = array();
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, null, B);
}
non_empty_array_pair_list(A) ::= AMPERSAND w_variable(B). {
	A = array();
	$a = new AOWP_PHPAmpersandExprElement($this->lex->line, B);
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, null, $a);
}
non_empty_array_pair_list(A) ::= non_empty_array_pair_list(B) COMMA expr(C) T_DOUBLE_ARROW expr(D). {
	A = B;
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, C, D);
}
non_empty_array_pair_list(A) ::= non_empty_array_pair_list(B) COMMA expr(C). {
	A = B;
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, null, C);
}
non_empty_array_pair_list(A) ::= expr(B) T_DOUBLE_ARROW expr(C). {
	A = array();
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, B, C);
}
non_empty_array_pair_list(A) ::= non_empty_array_pair_list(B) COMMA expr(C) T_DOUBLE_ARROW AMPERSAND w_variable(D). {
	A = B;
	$a = new AOWP_PHPAmpersandExprElement($this->lex->line, D);
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, C, $a);
}
non_empty_array_pair_list(A) ::= non_empty_array_pair_list(B) COMMA AMPERSAND w_variable(C). {
	A = B;
	$a = new AOWP_PHPAmpersandExprElement($this->lex->line, C);
	A[] = new AOWP_PHPArrayPairElement($this->lex->line, null, $a);
}


encaps_list(A) ::= encaps_list(B) encaps_var(C). {
	A = B;
	A[] = C;
}
encaps_list(A) ::= . {
	A = array();
}

encaps_var(A) ::= T_STRING(C). {
	A = C;
}
encaps_var(A) ::= T_NUM_STRING(C). {
	A = C;
}
encaps_var(A) ::= T_ENCAPSED_AND_WHITESPACE(C). {
	A = C;
}
encaps_var(A) ::= T_CHARACTER(C). {
	A = C;
}
encaps_var(A) ::= T_BAD_CHARACTER(C). {
	A = C;
}
encaps_var(A) ::= LBRACKET. {
	A = '[';
}
encaps_var(A) ::= RBRACKET. {
	A = ']';
}
encaps_var(A) ::= LCURLY. {
	A = '{';
}
encaps_var(A) ::= RCURLY. {
	A = '}';
}
encaps_var(A) ::= T_OBJECT_OPERATOR. {
	A = '->';
}
encaps_var(A) ::= T_VARIABLE(B). {
	A = B;
}
encaps_var_bracket_index(A) ::= T_STRING|T_NUM_STRING|T_VARIABLE(C). { A = C; }
encaps_var(A) ::= T_VARIABLE(B) LBRACKET encaps_var_bracket_index(C) RBRACKET. {
	A = B . '[' . C . ']';
}
encaps_var(A) ::= T_VARIABLE(B) T_OBJECT_OPERATOR T_STRING(C). {
	A = B . '->' . C;
}
encaps_var(A) ::= T_DOLLAR_OPEN_CURLY_BRACES expr(B) RCURLY. {
	A = new AOWP_PHPComplexVariableElement($this->lex->line, '${', B);
}
encaps_var(A) ::= T_DOLLAR_OPEN_CURLY_BRACES T_STRING_VARNAME(B) LBRACKET expr(C) RBRACKET RCURLY. {
	$v = new AOWP_PHPVariableElement($this->lex->line, B);
	$r = new AOWP_PHPReferenceVariableElement($this->lex->line, $v, C);	
	A = new AOWP_PHPComplexVariableElement($this->lex->line, '${', $r);
}
encaps_var(A) ::= T_CURLY_OPEN variable(B) RCURLY. {
	A = new AOWP_PHPComplexVariableElement($this->lex->line, '{', B);
}

internal_functions_in_yacc(A) ::= T_ISSET LPAREN isset_variables(B) RPAREN. {
	A = new AOWP_PHPIssetStatementElement($this->lex->line, B);
}
internal_functions_in_yacc(A) ::= T_EMPTY LPAREN variable(B) RPAREN. {
	A = new AOWP_PHPEmptyStatementElement($this->lex->line, B);
}
get_include_line(A) ::= T_INCLUDE. { A = $this->lex->line; }
internal_functions_in_yacc(A) ::= get_include_line(LINE) expr(B). {
	A = new AOWP_PHPFileIncludeStatementElement(LINE, 'include', B);
}
get_include_once_line(A) ::= T_INCLUDE_ONCE. { A = $this->lex->line; }
internal_functions_in_yacc(A) ::= get_include_once_line(LINE) expr(B). {
	A = new AOWP_PHPFileIncludeStatementElement(LINE, 'include_once', B);
}
internal_functions_in_yacc(A) ::= T_EVAL LPAREN expr(B) RPAREN. {
	A = new AOWP_PHPEvalStatementElement($this->lex->line, B);
}
get_require_line(A) ::= T_REQUIRE. { A = $this->lex->line; }
internal_functions_in_yacc(A) ::= get_require_line(LINE) expr(B). {
	A = new AOWP_PHPFileIncludeStatementElement(LINE, 'require', B);
}
get_require_once_line(A) ::= T_REQUIRE_ONCE. { A = $this->lex->line; }
internal_functions_in_yacc(A) ::= get_require_once_line(LINE) expr(B). {
	A = new AOWP_PHPFileIncludeStatementElement(LINE, 'require_once', B);
}

isset_variables(A) ::= variable(B). { 
	A = array();
	A[] = B; 
}
isset_variables(A) ::= isset_variables(B) COMMA variable(C). {
	A = B;
	A[] = C;
}

class_constant(A) ::= fully_qualified_class_name(B) T_PAAMAYIM_NEKUDOTAYIM T_STRING(C). {
	A = new AOWP_PHPClassConstVariableRefElement($this->lex->line, B, C);
}

fully_qualified_class_name(A) ::= T_STRING(B). { A = B; }

function_call(A) ::= T_STRING(B) LPAREN function_call_parameter_list(C) RPAREN. { 
	A = new AOWP_PHPFunctionCallElement($this->lex->line, B, C);
}
function_call(A) ::= fully_qualified_class_name(CLAS) T_PAAMAYIM_NEKUDOTAYIM T_STRING(FUNC) LPAREN function_call_parameter_list(PL) RPAREN. {
	A = new AOWP_PHPStaticMethodCallElement($this->lex->line, CLAS, FUNC, PL);
}
function_call(A) ::= fully_qualified_class_name(CLAS) T_PAAMAYIM_NEKUDOTAYIM variable_without_objects(V) LPAREN function_call_parameter_list(PL) RPAREN. {
	A = new AOWP_PHPStaticMethodCallWithVariableElement($this->lex->line, CLAS, V, PL);
}
function_call(A) ::= variable_without_objects(B) LPAREN function_call_parameter_list(PL) RPAREN. {
	A = new AOWP_PHPFunctionCallWithVariableElement($this->lex->line, B, PL);
}

scalar(A) ::= T_STRING(B). { A = B; }
scalar(A) ::= T_STRING_VARNAME(B). { A = B; }
scalar(A) ::= class_constant(B). { A = B; }
scalar(A) ::= common_scalar(B). { A = B; }
scalar(A) ::= DOUBLEQUOTE encaps_list(B) DOUBLEQUOTE. {
	A = new AOWP_PHPQuoteExprElement($this->lex->line, 'doublequote', B);
}
scalar(A) ::= SINGLEQUOTE encaps_list(B) SINGLEQUOTE. {
	A = new AOWP_PHPQuoteExprElement($this->lex->line, 'singlequote', B);
}
scalar(A) ::= T_START_HEREDOC(HERE) encaps_list(B) T_END_HEREDOC(DOC). {
	A = new AOWP_PHPHeredocExprElement($this->lex->line, B, DOC);
}

class_name_reference(A) ::= T_STRING(B). { A = B; }
class_name_reference(A) ::= dynamic_class_name_reference(B). { A = B; }

dynamic_class_name_reference(A) ::= base_variable(B) T_OBJECT_OPERATOR object_property(C) dynamic_class_name_variable_properties(D). {
	$p = new AOWP_PHPObjectPropertyElement($this->lex->line, C, null);
	A = new AOWP_PHPObjectOperatorElement($this->lex->line, B, $p);
}
dynamic_class_name_reference(A) ::= base_variable(B). { A = B; }

dynamic_class_name_variable_properties(A) ::= dynamic_class_name_variable_properties(B) dynamic_class_name_variable_property(C). {
	A = B;
	A[] = C;
}
dynamic_class_name_variable_properties(A) ::= . {
	A = array();
}

dynamic_class_name_variable_property(A) ::= T_OBJECT_OPERATOR object_property(B). {
	A = new AOWP_PHPObjectPropertyElement($this->lex->line, B, null);
}

ctor_arguments(A) ::= LPAREN function_call_parameter_list(B) RPAREN. { A = B; }
ctor_arguments(A) ::= . { A = array(); }

possible_comma(A) ::= COMMA. { A = true; }
possible_comma(A) ::= . { A = false; }

for_expr(A) ::= non_empty_for_expr(B). { A = B; }
for_expr(A) ::= . { A = array(); }

non_empty_for_expr(A) ::= non_empty_for_expr(B) COMMA expr(C). {
	A = B;
	A[] = C;
}
non_empty_for_expr(A) ::= expr(B). {
	A = array();
	A[] = B;
}

is_reference(A) ::= AMPERSAND. { A = true; }
is_reference(A) ::= . { A = false; }
