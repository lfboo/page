<?php
/**
 * pager
 */

class PageTool{

    protected $options = array(
        //要传入的参数
        'totalItems'  => 0,   //需要分页的记录总数
        'currentPage' => 1,      //当前页
        'pageSize'    => 10,     //每页显示多少条数据记录
        'urlParams'   => null,   //链接参数
        'delta'       => 2,      //当前页前后显示的页数
    );

    protected $firstPage = 1;    //第一页
    protected $endPage   = null; //最后一页
    protected $totalPages = null; //总页数
    protected $prePage = null;   //上一页，如果当前页为firstPage,则为null
    protected $nextPage = null;  //下一页，如果当前页为endPage，则为null
    protected $offset = 0;       //移动偏移量，为delta * 2 + 1
    protected $pages = '';     //分页列表,最终输出到页面上的内容
    protected $url   = null;     //链接参数


    public function __construct(array $options){
        if(!empty($options)) {
            $this->options = array_merge($this->options,$options);
        }
        
        $this->build();
    }    

    public function build(){
        $this->init();
        $this->buildPages();
    }

    private function init(){
        if(!is_numeric($this->options['totalItems']) || $this->options['totalItems'] < 0) {
            throw new Exception(__METHOD__." error,totalItems must be integer");
        }        
        //总页数
        $this->totalPages = ceil($this->options['totalItems']/$this->options['pageSize']);         
        //移动偏移量
        if(!is_numeric($this->options['delta']) || $this->options['delta'] < 0) {
            throw new Exception("error");
        }        
        //偏移量
        $this->offset = $this->options['delta'] * 2 + 1;
        //上一页
        $this->prePage = ($this->options['currentPage'] < 1) ? 1 : ($this->options['currentPage'] - 1);
        //下一页
        $this->nextPage = ($this->options['currentPage'] > $this->totalPages) ? $this->totalPages : ($this->options['currentPage'] + 1);
        //链接参数
        $this->url = $this->buildUrl($this->options['urlParams']);
    }

    private function buildUrl($urlParams){
       $_params = null;
       if(is_array($urlParams)) {
            $_params = http_build_query($urlParams);
       }else{
            $_params = $urlParams;
       } 
       if(is_null($_params)) {
            $_url = '';
        }else{
            $_url = '&'.$_params;
        }
        return $_url;
    }

    private function buildPages(){
        $from = 0;
        $to = 0;
 
        if($this->totalPages < $this->offset){
            $from = 1;
            $to = $this->totalPages;
         }elseif($this->options['currentPage'] + $this->options['delta'] >= $this->totalPages){
            $to = $this->totalPages;
            $from = $this->totalPages - $this->offset + 1;
         }elseif($this->options['currentPage'] - $this->options['delta'] < 1){
            $from = 1;
            $to = $this->offset;
         }else{
            $from = $this->options['currentPage'] - $this->options['delta'];
            $to = $this->options['currentPage'] + $this->options['delta'];
         }

         if($this->options['currentPage'] > 1){
            $this->pages .= "<a href='?page=".$this->prePage.$this->url."'>上一页</a>&nbsp;";
         }
 
         if($from > 1){
            $this->pages .= "<a href='?page=1".$this->url."'>1</a>&nbsp;";
         }
         if($from > 2){
            $this->pages .=  "...&nbsp;";
         }
  
         while($from <= $to){
            if($from == $this->options['currentPage']){
                $this->pages .=  '<span>'.$from.'</span>&nbsp;';
            }else{
                $this->pages .= '<a href="?page='.$from.$this->url.'">'.$from.'</a>&nbsp;';
            }
            $from++;
          }
  
          if($to < $this->totalPages-1){
            $this->pages .= "...&nbsp;";
          }
  
          if($to < $this->totalPages){
            $this->pages .=  '<a href="page='.$this->totalPages.'">'.$this->totalPages.'</a>&nbsp;';
          } 
        
          if($this->options['currentPage'] < $this->totalPages) {
            $this->pages .= "<a href='?page=".$this->nextPage.$this->url."'>下一页</a>";
          }
    } 
	
	  public function getPages(){
		  return $this->pages;
	  }

}


