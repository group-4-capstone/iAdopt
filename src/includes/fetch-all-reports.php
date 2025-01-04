<?php

// process_data.php

if (isset($_POST["query"])) {

    $connect = new PDO("mysql:host=localhost; dbname=iadopt", "root", "");

    $data = array();

    $limit = 5;
    $page = isset($_POST["page"]) && $_POST["page"] > 1 ? intval($_POST["page"]) : 1;
    $start = ($page - 1) * $limit;

    $sort_order = isset($_POST["sort_order"]) && $_POST["sort_order"] === 'asc' ? 'ASC' : 'DESC';


    $condition = trim(preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]));

    $query_params = [
        ':report_date'    => '%' . $condition . '%',
        ':animal_id'      => '%' . $condition . '%',
        ':first_name'     => '%' . $condition . '%',
        ':last_name'      => '%' . $condition . '%',
        ':location'       => '%' . $condition . '%',
        ':type'           => '%' . $condition . '%',
        ':animal_status'  => '%' . $condition . '%',
        ':report_type'  => '%' . $condition . '%',
        ':deny_reason'    => '%' . $condition . '%'
    ];

    $query = "
    SELECT 
        rescue.rescue_id, 
        rescue.report_date, 
        rescue.report_type, 
        animals.animal_id, 
        animals.type, 
        rescue.location, 
        animals.animal_status, 
        users.first_name, 
        users.last_name, 
        rescue.animal_image,
        rescue.deny_reason
    FROM rescue
    INNER JOIN animals ON rescue.animal_id = animals.animal_id
    INNER JOIN users ON rescue.user_id = users.user_id
    WHERE rescue.report_type = 'report' 
      AND (
          rescue.report_date LIKE :report_date OR 
          rescue.report_type LIKE :report_type OR
          animals.animal_id LIKE :animal_id OR 
          users.first_name LIKE :first_name OR 
          users.last_name LIKE :last_name OR 
          animals.animal_status LIKE :animal_status OR 
          animals.type LIKE :type OR 
          rescue.location LIKE :location OR
          rescue.deny_reason LIKE :deny_reason
      )
    ORDER BY rescue.report_date $sort_order
";


    $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit;

    // Execute query to get total data
    $statement = $connect->prepare($query);
    $statement->execute($query_params);
    $total_data = $statement->rowCount();

    // Execute query with limit
    $statement = $connect->prepare($filter_query);
    $statement->execute($query_params);
    $result = $statement->fetchAll();

    // Highlight matching parts safely
    $escaped_condition = htmlspecialchars($condition, ENT_QUOTES, 'UTF-8');
    $highlighted_condition = '<span style="background-color:#555; color:#fff">' . $escaped_condition . '</span>';

    foreach ($result as $row) {
        $data[] = array(
            'rescue_id'     => $row["rescue_id"],
            'animal_id'     => $row["animal_id"],
            'report_date'   => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["report_date"])),
            'type'          => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["type"])),
            'report_type'          => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["report_type"])),
            'location'      => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["location"])),
            'first_name'    => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["first_name"])),
            'last_name'     => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["last_name"])),
            'animal_status' => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["animal_status"])),
            'deny_reason'   => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["deny_reason"])),
            'animal_image'  => $row["animal_image"],
        );
    }

    // Generate pagination HTML
    $pagination_html = '<div align="center"><ul class="pagination">';

    $total_links = ceil($total_data / $limit);

    $previous_link = $page > 1 
        ? '<li class="page-item"><a class="page-link" href="javascript:load_data_deny(`' . $_POST["query"] . '`, ' . ($page - 1) . ')"><</a></li>' 
        : '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';

    $next_link = $page < $total_links 
        ? '<li class="page-item"><a class="page-link" href="javascript:load_data_deny(`' . $_POST["query"] . '`, ' . ($page + 1) . ')">></a></li>' 
        : '<li class="page-item disabled"><a class="page-link" href="#">></a></li>';

    $page_links = '';
    for ($count = 1; $count <= $total_links; $count++) {
        $active_class = $page == $count ? ' active' : '';
        $page_links .= '<li class="page-item' . $active_class . '"><a class="page-link" href="javascript:load_data_deny(`' . $_POST["query"] . '`, ' . $count . ')">' . $count . '</a></li>';
    }

    $pagination_html .= $previous_link . $page_links . $next_link . '</ul></div>';

    // Return response
    echo json_encode([
        'data'       => $data,
        'pagination' => $pagination_html,
        'total_data' => $total_data
    ]);
}
?>
