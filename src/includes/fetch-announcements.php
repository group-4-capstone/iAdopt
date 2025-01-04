<?php

// process_data.php

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
        ':title'       => '%' . $condition . '%',
        ':description' => '%' . $condition . '%',
    ];

    // Query to fetch announcements with search conditions
    $query = "
    SELECT announcements.announcement_id, title, description, image, announcement_status, publish_date, first_name, last_name, announcement_date
    FROM announcements
    INNER JOIN users ON announcements.admin = users.user_id
    WHERE title LIKE :title OR description LIKE :description
    ORDER BY announcement_id DESC
    ";

    // Add LIMIT for pagination
    $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit;

    // Prepare and execute the statement to get the total data count
    $statement = $connect->prepare($query);
    $statement->execute($query_params);
    $total_data = $statement->rowCount();

    // Prepare the filtered data
    $statement = $connect->prepare($filter_query);
    $statement->execute($query_params);
    $result = $statement->fetchAll();

    // Highlight matching parts safely
    $escaped_condition = htmlspecialchars($condition, ENT_QUOTES, 'UTF-8');
    $highlighted_condition = '<span style="background-color:#555; color:#fff">' . $escaped_condition . '</span>';

    foreach ($result as $row) {
        $data[] = [
            'announcement_id'     => $row["announcement_id"],
            'title'               => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row['title'])),
            'description'         => str_ireplace($escaped_condition, $highlighted_condition, $row['description']),
            'image'               => $row['image'], 
            'announcement_status' => $row['announcement_status'],
            'publish_date'        => $row['publish_date'],
            'first_name'          => $row["first_name"],
            'last_name'           => $row["last_name"],
            'announcement_date'   => $row['announcement_date']
        ];
    }

    // Handle pagination
    $pagination_html = '<div align="center"><ul class="pagination">';

    $total_links = ceil($total_data / $limit);
    $previous_link = $page > 1 ? '<li class="page-item"><a class="page-link" href="javascript:load_data_announcements(`' . $_POST["query"] . '`, ' . ($page - 1) . ')"><</a></li>' : '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';

    $next_link = $page < $total_links ? '<li class="page-item"><a class="page-link" href="javascript:load_data_announcements(`' . $_POST["query"] . '`, ' . ($page + 1) . ')">></a></li>' : '<li class="page-item disabled"><a class="page-link" href="#">></a></li>';

    $page_links = '';
    for ($count = 1; $count <= $total_links; $count++) {
        $active_class = $page == $count ? ' active' : '';
        $page_links .= '<li class="page-item' . $active_class . '"><a class="page-link" href="javascript:load_data_announcements(`' . $_POST["query"] . '`, ' . $count . ')">' . $count . '</a></li>';
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
