<?php

/**
 * get 标签解析
 * {% get field='id,username' order="id DESC" num=10 call='UUM_Logic_Test::getList'%}
 *  {% for user in list%}
 *       <li>{{ user.username }}</li>
 *  {% endfor %}
 */
class Tag_TokenParser_get extends Twig_TokenParser{
    
    public function parse(Twig_Token $token){
        $parser = $this->parser;
        $stream = $parser->getStream();
        //处理标签属性
        $arr = C('TAG:get',array('field','where','order','num','data','call'));
        $i = count($arr)-1;
        $name='';
        $nodes = $attrs = null;
        do{
            $name = $stream->expect(Twig_Token::NAME_TYPE)->getValue();
            $stream->expect(Twig_Token::OPERATOR_TYPE, '=');
            $attr = $attrs[$name] = $parser->getExpressionParser()->parseExpression();
            $nodes[$name] = $attr->getAttribute('value');
            if(!in_array($stream->getCurrent()->getValue(),$arr)){//没有可用taken时中断循环,否则下一个将导致严重错误.
                break;
            }
            $i-=1;
        }while ($i);
        /*
        //获得标签文本
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        $nodes['body'] = $parser->subparse(array($this, 'decideEnd'));
        $end = false;
        while (!$end) {
            switch ($stream->next()->getValue()) {
                case 'endget':
                    $end = true;
                    break;
                default:
                    throw new Twig_Error_Syntax(sprintf('Unexpected end of template. Twig was looking for the following tags "endget" to close the "get" block started at line %d)', $lineno), $stream->getCurrent()->getLine(), $stream->getFilename());
            }
        }*/
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        return new Tag_Node_get($nodes, $attrs, $token->getLine(), $this->getTag());
    }
    public function decideEnd(Twig_Token $token){
        return $token->test(array('endget'));
    }
    public function getTag(){
        return 'get';
    }
}