<?php
/**
 * get 标签编译
 */
class Tag_Node_get extends Twig_Node
{
    public function __construct($name,$value, $line, $tag = null)
    {
        parent::__construct($value,$name, $line, $tag);
    }

    public function compile(Twig_Compiler $compiler)
    {
        if($this->hasAttribute('data')){
            $key=$this->getAttribute('data');
        }else{
            $key='list';
        }

        $compiler->addDebugInfo($this);
        if($this->hasAttribute('call')){
            $call = $this->getAttribute('call');
        }else{
            if($this->hasAttribute('table')){
                $call = "DATA_Logic_".ucfirst($table)."::getList";
            }else{
                $call = "DATA_Logic_Test::getList";
            }
        }
        $param = '';
        if($this->hasAttribute('field')){
            $param = $this->getAttribute('field');
        }else{
            $param = '*';
        }
        if($this->hasAttribute('where')){
            $param .=';'.'';
            $str_where = $this->getAttribute('where');
        }else{
            $param .=';'.'';
        }
        if($this->hasAttribute('order')){
            $param .=';'. $this->getAttribute('order');
        }else{
            $param.=';'.'id desc';
        }
        $param.=';0';
        if($this->hasAttribute('num')){
            $param.=';'.$this->getAttribute('num');
        }else{
            $param.=';'.'10';
        }
        $compiler->write("if(!is_callable('".$call."')){ throw new Exception(\"".$call." is not callable\", 1);
        }")->raw(";\n");
        $compiler->write("\$param = explode(';','".$param."')")->raw(";\n");
        $compiler->write("\$param[1] = $str_where")->raw(";\n");
        $compiler->write("\$context['".$key."'] = call_user_func_array('".$call."',\$param)")->raw(";\n");
    }
}