<?php
include 'connection.php';

$limit = 5;

$page = 1;

if (isset($_POST['page']) && $_POST['page'] > 1) {
    $start = ($_POST['page'] - 1) * $limit;
    $page = $_POST['page'];
} else {
    $start = 0;
}

$query = "SELECT * FROM test ";

if ($_POST['query'] != '') {
    $query .= 'WHERE first_name LIKE "%'.$_POST['query'].'%" ';
}

$query .= "ORDER BY id ASC ";

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

//  without filter
$statement = mysqli_query($con, $query);

$total_data = mysqli_num_rows($statement);

// with filter
$statement = mysqli_query($con, $filter_query);

$output = '
    <label>Total Records - '.$total_data.'</label>
    <table class="table table-striped table-bordered">
        <tr>
            <td>ID</td>
            <td>Post Title</td>
        </tr>
';

if ($total_data > 0) {
    while($result = mysqli_fetch_assoc($statement)){
        $output .= '
        <tr>
            <td>'.$result['id'].'</td>
            <td>'.$result['first_name'].' '.$result['last_name'].'</td>
        </tr>
        ';
    }
} else {
    $output .= '
    <tr>
        <td colspan="2" align="center">NO Data Found..</td>
    </tr>
    ';
}

$output .= '
</table>
</br>
<div align="center">
    <ul class="pagination">
';

$total_links = ceil($total_data / $limit);

$prev_link = '';

$next_link = '';

$page_link = '';

if ($total_links > 4) {
    if ($page < 5) {
        for ($count = 1; $count<=5; $count++) {
            $page_array[] = $count;
        }
        $page_array[] = '...';
        $page_array[] = $total_links;
    } else {

        $end_limit = $total_links - 5;

        if ($page > $end_limit) {
            $page_array[] = 1;
            $page_array[] = '...';

            for ($count = $end_limit; $count<=$total_links; $count++) {
                $page_array[] = $count;
            }
        } else {
            $page_array[] = 1;
            $page_array[] = '...';
            
            for ($count = $page - 1; $count <= $page + 1; $count++) {
                $page_array[] = $count;
            }
            $page_array[] = '...';
            $page_array[] = $total_links;
        }
    }
} else {
    for ($count = 1; $count<=$total_links; $count++) {
        $page_array[] = $count;
    }
}
for ($count = 0; $count < count($page_array); $count++) {
    
    if ($page == $page_array[$count]) {
        $page_link .= '
        <li class="page_item active">
            <a class="page-link" href="#" >'.$page_array[$count].'
                <span class="sr-only">(currant)</span>
            </a>
        </li>
        '; 

        $prev_id = $page_array[$count] - 1;

        if ($prev_id > 0) {
            $prev_link = '<li class="page_item">
            <a class="page-link" href="javascript:void(0)" data-page="'.$prev_id.'">Prev</a>
            </li>';
        } else {
            $prev_link = '<li class="page_item disabled">
            <a class="page-link" href="#" style="pointer-events: none">Prev</a>
            </li>';
        }
        
        $next_id = $page_array[$count] + 1;
        
        if ($next_id > $total_links) {
            $next_link = '<li class="page_item disabled">
            <a class="page-link" href="#" style="pointer-events: none">Next</a>
            </li>
            ';
        } else {
            $next_link = '<li class="page_item">
                <a class="page-link" href="javascript:void(0)" data-page="'.$next_id.'">Next</a>
            </li>';
        }

    } else {
        if ($page_array[$count] == '...') {
            $page_link .= '<li class="page_item disabled">
            <a class="page-link" href="#" style="pointer-events: none">...</a>
            </li>';
        } else {
            $page_link .= '<li class="page_item">
            <a class="page-link" href="javascript:void(0)" data-page="'.$page_array[$count].'">'.$page_array[$count].'</a>
            </li>';
        }
    }
}

$output .= $prev_link . $page_link . $next_link;

echo $output;

?>