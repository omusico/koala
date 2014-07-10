<?php

/**
 * get 标签解析
 * {% get field='id,username' order="id DESC" num=10 call='UUM_Logic_Test::getList' data='list'%}
 * {% for user in list%}
 *    <li>{{ user.username }}</li>
 * {% endfor %}
 *
 * {% get field,order,num,call,data='id,username',"id DESC",10,'UUM_Logic_Test::getList','list'%}
 * {% for user in list%}
 *    <li>{{ user.username }}</li>
 * {% endfor %}
 *
 * {% get field,order,num,call,data='id,username',"id DESC",10,'\\UUM\\Logic\\Test::getList','list'%}
 * {% for user in list%}
 *    <li>{{ user.username }}</li>
 * {% endfor %}
 * 
 */
class Tag_TokenParser_get extends Twig_TokenParser{
    
    public function parse(Twig_Token $token){
        //获得当前Token所在行号
        $lineno = $token->getLine();
        //获得stream
        $stream = $this->parser->getStream();

        //获得当前name
        $name = $stream->getCurrent()->getValue();

        /*{% get name1,name2='value1','value2'%}*/
        //获得names
        $names = $this->parser->getExpressionParser()->parseAssignmentExpression();
        if(($names_num = count($names))>1){
            //如果下一个为'='
            if ($stream->nextIf(Twig_Token::OPERATOR_TYPE, '=')) {
                //获得values
                $values  = $this->parser->getExpressionParser()->parseMultitargetExpression();
                foreach ($values as $key => $value) {
                    $attrs_arr[] = $value;
                    $attrs[] = $value->getAttribute('value');
                }
                if ($names_num !== count($values)) {
                    throw new Twig_Error_Syntax("When using get, you must have the same number of variables and assignments.", $stream->getCurrent()->getLine(), $stream->getFilename());
                }
            }else{
                throw new Twig_Error_Syntax("get标签使用时必须使用操作符=", $stream->getCurrent()->getLine(), $stream->getFilename());
            }
            foreach ($names as $key => $value) {
                $names_arr[] = $value->getAttribute('name');
            }
            $nodes = array_combine($names_arr,$attrs);
            $attrs = array_combine($names_arr,$attrs_arr);
        }else{
            /*{% get name1='value1' name2='value2'%}*/
            while(!$stream->test(Twig_Token::BLOCK_END_TYPE)){
                //判断是否是期望的'='
                $op = $stream->expect(Twig_Token::OPERATOR_TYPE, '=');
                $attr = $attrs[$name] = $this->parser->getExpressionParser()->parseExpression();
                $nodes[$name] = $attr->getAttribute('value');
                if($stream->test(Twig_Token::BLOCK_END_TYPE)){
                    break;
                }
                $name = $stream->expect(Twig_Token::NAME_TYPE)->getValue();
            }
        }
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        return new Tag_Node_get($nodes, $attrs, $token->getLine(), $this->getTag());
    }
    public function getTag(){
        return 'get';
    }
}