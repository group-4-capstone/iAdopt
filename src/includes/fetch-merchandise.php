<?php

// merch_data.php

if (isset($_POST["query"])) {

    $connect = new PDO("mysql:host=localhost; dbname=iadopt", "root", "");

    $data = array();

    $limit = 5;
    $page = $_POST["page"] > 1 ? $_POST["page"] : 1;
    $start = ($page - 1) * $limit;

    // Clean the search query
    $condition = trim(preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]));

    // Parameters to use in the SQL query
    $query_params = [
        ':item' => '%' . $condition . '%',
        ':link' => '%' . $condition . '%'
    ];

    // Base query to fetch merchandise
    $query = "
    SELECT merch_id, item, link, image, status, date
    FROM merchandise
    WHERE item LIKE :item OR link LIKE :link
    ORDER BY date DESC
    ";

    // Add LIMIT for pagination
    $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit;

    // Prepare and execute the statement to count total results
    $statement = $connect->prepare($query);
    $statement->execute($query_params);
    $total_data = $statement->rowCount();

    // Prepare and execute the statement to fetch paginated results
    $statement = $connect->prepare($filter_query);
    $statement->execute($query_params);
    $result = $statement->fetchAll();

    // Highlight matching parts safely
    $escaped_condition = htmlspecialchars($condition, ENT_QUOTES, 'UTF-8');
    $highlighted_condition = '<span style="background-color:#555; color:#fff">' . $escaped_condition . '</span>';

    foreach ($result as $row) {
        $data[] = [
            'merch_id' => $row['merch_id'],
            'item'     => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row['item'])),
            'link'     => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row['link'])),
            'image'    => $row['image'],  // Image does not need highlighting
            'status'   => htmlspecialchars($row['status']),
            'date'     => htmlspecialchars($row['date'])
        ];
    }

    // Handle pagination
    $pagination_html = '<div class="pagination-container"><ul class="pagination">';

    $total_links = ceil($total_data / $limit);

    $previous_link = $page > 1 ? '<li class="page-item"><a class="page-link" href="javascript:load_data_merch(`' . $_POST["query"] . '`, ' . ($page - 1) . ')"><</a></li>' : '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';

    $next_link = $page < $total_links ? '<li class="page-item"><a class="page-link" href="javascript:load_data_merch(`' . $_POST["query"] . '`, ' . ($page + 1) . ')">></a></li>' : '<li class="page-item disabled"><a class="page-link" href="#">></a></li>';

    $page_links = '';
    for ($count = 1; $count <= $total_links; $count++) {
        $active_class = $page == $count ? ' active' : '';
        $page_links .= '<li class="page-item' . $active_class . '"><a class="page-link" href="javascript:load_data_merch(`' . $_POST["query"] . '`, ' . $count . ')">' . $count . '</a></li>';
    }

    $pagination_html .= $previous_link . $page_links . $next_link . '</ul></div>';

    // Return the data and pagination
    echo json_encode([
        'data'       => $data,
        'pagination' => $pagination_html,
        'total_data' => $total_data
    ]);
}

?>
