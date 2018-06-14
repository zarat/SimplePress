<script src="./js/admin.js"></script>
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/jquery.dataTables.js"></script>
<script type="text/javascript" src="./js/jquery.dataTables.min.js"></script>

<link href="./css/jquery.dataTables_themeroller.min.css" type="text/css" rel="stylesheet">
<link href="./css/jquery.dataTables_themeroller.css" type="text/css" rel="stylesheet">
<link href="./css/jquery.dataTables.css" type="text/css" rel="stylesheet">

<script type="text/javascript">
$(document).ready(function() { 
    $('table#item_list').dataTable( { 'paging':   true, 'ordering': false, 'info': true } ); 
});
</script>

<div class="sp-content">

<div class="sp-content-item">

<div class="sp-content-item-head"><a href="../admin/taxonomy.php?action=add">Neu</a></div>

<div class="sp-content-item-body">

<table id="item_list" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
    <th></th>
    </tr>
    </thead>
    <tfoot></tfoot>
    <tbody>

<?php

$taxonomy = new taxonomy();
$taxonomies = $taxonomy->get_existing_top_taxonomies();

foreach($taxonomies as $taxonomy){      
    echo "\n<tr>";      
    echo "<td><a href='../admin/taxonomy.php?action=list_children&id=$taxonomy[id]'>$taxonomy[taxonomy]</a></td>";      
    echo "\n</tr>\n";    
}

?>

</tbody>
</table>        
        
</div>
        
</div>

</div>

<?php include "footer.php"; ?>