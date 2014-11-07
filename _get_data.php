<?php
function __autoload($class_name) {
    include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
}

$dataObj = new Data();
$data = $dataObj->getData();
?>
<table>
    <thead>
        <th>ID</th>
        <th>Group</th>
        <th>Code</th>
        <th>Name</th>
        <th>Price</th>
    </thead>
    <?php
	if(empty($_GET['source'])){
		echo '<tr><td colspan="5">Please, select data source!</td></tr>';
	}
    $rows = '';
    $i = 1;
    foreach($data as $currency)
    {
        $rows .= '<tr>';
        $rows .= '<td>' . $i++ . '</td>';
        $rows .= '<td>' . $currency['group'] . '</td>';
        $rows .= '<td>' . $currency['code'] . '</td>';
        $rows .= '<td>' . $currency['name'] . '</td>';
        $rows .= '<td>' . $currency['value'] . '</td>';
        $rows .= '</tr>';
    }
    echo $rows;
    ?>
</table>
