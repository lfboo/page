page
====

php page tool,refer to the PEAR::Pager


======================usage=======================
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$params = array(
    'totalItems' => 50,
    'delta' => 2,
    'currentPage' => $page,
    'pageSize' => 3, 
    'urlParams' => array(
        'name' => 'xxx',
        'age' => 20
    )
);
$page = new PageTool($params);
echo $page->getPages();
===================end usage=====================
