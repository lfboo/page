page
====

php page tool,refer to the PEAR::Pager


======================usage======================= <br>
$page = isset($_GET['page']) ? $_GET['page'] : 1;<br />
$params = array( <br>
    'totalItems' => 50, <br>
    'delta' => 2, <br>
    'currentPage' => $page, <br>
    'pageSize' => 3,  <br>
    'urlParams' => array(  <br>
        'name' => 'xxx',   <br>
        'age' => 20       <br>
    )  <br>
);  <br>
$page = new PageTool($params);  <br>
echo $page->getPages();<br>
===================end usage=====================

===================effect========================<br />
上一页 1 ... 5 6 7 8 9 ... 17 下一页
