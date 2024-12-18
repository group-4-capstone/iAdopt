<?php

// process_data.php

if (isset($_POST["query"])) {
    $connect = new PDO("mysql:host=localhost;dbname=iadopt", "root", "");
    $data = [];
    $limit = 5;
    $page = isset($_POST["page"]) && $_POST["page"] > 1 ? $_POST["page"] : 1;
    $start = ($page - 1) * $limit;

    // Handle search condition
    $condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]);
    $condition = trim($condition);
    $condition = str_replace(" ", "%", $condition);
    
    $query_params = [];
    
    $base_query = "SELECT * FROM applications 
                   INNER JOIN users ON applications.user_id = users.user_id 
                   INNER JOIN animals ON applications.animal_id = animals.animal_id";

    // Add search condition if provided
    if (!empty($condition)) {
        $base_query .= " WHERE name LIKE :name OR first_name LIKE :first_name OR last_name LIKE :last_name OR
         application_date LIKE :application_date";
        $query_params = [
            ':name' => '%' . $condition . '%',
            ':application_date' => '%' . $condition . '%',
            ':first_name' => '%' . $condition . '%',
            ':last_name' => '%' . $condition . '%'
        ];
    }

    $base_query .= " ORDER BY applications.application_id DESC";
    $filter_query = $base_query . " LIMIT $start, $limit";

    // Get total data count
    $statement = $connect->prepare($base_query);
    $statement->execute($query_params);
    $total_data = $statement->rowCount();

    // Fetch paginated data
    $statement = $connect->prepare($filter_query);
    $statement->execute($query_params);
    $results = $statement->fetchAll();

    // Highlight search terms if applicable
    $replace_array_1 = explode('%', $condition);
    $replace_array_2 = array_map(function ($item) {
        return '<span style="background-color:#' . rand(100000, 999999) . '; color:#fff">' . $item . '</span>';
    }, $replace_array_1);

    foreach ($results as $row) {
        $data[] = [
            'application_id'     => $row["application_id"],
            'first_name'          => str_ireplace($replace_array_1, $replace_array_2, $row["first_name"]),
            'last_name'          => str_ireplace($replace_array_1, $replace_array_2, $row["last_name"]),
            'application_date'               => str_ireplace($replace_array_1, $replace_array_2, $row["application_date"]),
            'name'               => str_ireplace($replace_array_1, $replace_array_2, $row["name"]),
            'email'              => $row['email'],
            'complete_address'   => $row['complete_address'],
            'application_status' => $row['application_status']
        ];
    }

    // Generate pagination links
    $total_links = ceil($total_data / $limit);
    $pagination_html = '<div align="center"><ul class="pagination">';

    // Previous link
    $previous_page = $page > 1 ? $page - 1 : 0;
    $pagination_html .= $previous_page ?
        '<li class="page-item"><a class="page-link" href="javascript:load_data(`' . $_POST["query"] . '`, ' . $previous_page . ')"><</a></li>' :
        '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';

    // Page links
    for ($count = 1; $count <= $total_links; $count++) {
        if ($count == $page) {
            $pagination_html .= '<li class="page-item active"><a class="page-link" href="#">' . $count . '</a></li>';
        } else {
            $pagination_html .= '<li class="page-item"><a class="page-link" href="javascript:load_data(`' . $_POST["query"] . '`, ' . $count . ')">' . $count . '</a></li>';
        }
    }

    // Next link
    $next_page = $page < $total_links ? $page + 1 : 0;
    $pagination_html .= $next_page ?
        '<li class="page-item"><a class="page-link" href="javascript:load_data(`' . $_POST["query"] . '`, ' . $next_page . ')">></a></li>' :
        '<li class="page-item disabled"><a class="page-link" href="#">></a></li>';

    $pagination_html .= '</ul></div>';

    // Output the result
    echo json_encode([
        'data'        => $data,
        'pagination'  => $pagination_html,
        'total_data'  => $total_data
    ]);
}

?>
