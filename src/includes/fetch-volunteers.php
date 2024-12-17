<?php

// volunteers_data.php

if (isset($_POST["query"])) {

    // Database connection
    $connect = new PDO("mysql:host=localhost; dbname=iadopt", "root", "");

    // Pagination variables
    $limit = 5;
    $page = isset($_POST["page"]) && $_POST["page"] > 1 ? $_POST["page"] : 1;
    $start = ($page - 1) * $limit;

    $condition = '';
    $sample_data = [];

    // Handle search query
    if (!empty($_POST["query"])) {
        $condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]);
        $condition = trim($condition);
        $condition = str_replace(" ", "%", $condition);

        $sample_data = [
            ':last_name' => '%' . $condition . '%',
            ':date_active' => '%' . $condition . '%'
        ];

        $query = "
        SELECT * 
        FROM volunteers
        WHERE last_name LIKE :last_name OR date_active LIKE :date_active
        ";
    } else {
        $query = "
        SELECT * 
        FROM volunteers
        ";
    }

    // Prepare total data count
    $statement = $connect->prepare($query);
    $statement->execute($sample_data);
    $total_data = $statement->rowCount();

    // Add pagination to query
    $filter_query = $query . " LIMIT $start, $limit";
    $statement = $connect->prepare($filter_query);
    $statement->execute($sample_data);

    $result = $statement->fetchAll();
    $data = [];
    $replace_array_1 = explode('%', $condition);
    $replace_array_2 = [];

    // Generate highlighted text for search matches
    foreach ($replace_array_1 as $row_data) {
        $replace_array_2[] = '<span style="background-color:#' . rand(100000, 999999) . '; color:#fff">' . $row_data . '</span>';
    }

    // Process query results
    foreach ($result as $row) {
        $data[] = [
            'volunteer_id' => $row["volunteer_id"],
            'last_name' => str_ireplace($replace_array_1, $replace_array_2, $row["last_name"]),
            'first_name' => $row['first_name'],
            'date_active' => str_ireplace($replace_array_1, $replace_array_2, $row["date_active"]),
            'role' => $row['role'],
            'status' => $row['status'],
            'date_inactive' => $row['date_inactive']
        ];
    }

   
    // Handle pagination
    $pagination_html = '<div class="pagination-container"><ul class="pagination">';

    $total_links = ceil($total_data / $limit);
    $previous_link = $page > 1 ? '<li class="page-item"><a class="page-link" href="javascript:load_data_volunteers(`' . $_POST["query"] . '`, ' . ($page - 1) . ')"><</a></li>' : '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';

    $next_link = $page < $total_links ? '<li class="page-item"><a class="page-link" href="javascript:load_data_volunteers(`' . $_POST["query"] . '`, ' . ($page + 1) . ')">></a></li>' : '<li class="page-item disabled"><a class="page-link" href="#">></a></li>';

    $page_links = '';
    for ($count = 1; $count <= $total_links; $count++) {
        $active_class = $page == $count ? ' active' : '';
        $page_links .= '<li class="page-item' . $active_class . '"><a class="page-link" href="javascript:load_data_volunteers(`' . $_POST["query"] . '`, ' . $count . ')">' . $count . '</a></li>';
    }

    $pagination_html .= $previous_link . $page_links . $next_link . '</ul></div>';


    // Output response
    echo json_encode([
        'data' => $data,
        'pagination' => $pagination_html,
        'total_data' => $total_data
    ]);
}

?>
