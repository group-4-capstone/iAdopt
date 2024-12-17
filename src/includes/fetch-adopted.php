<?php

// reports_data.php

if (isset($_POST["query"])) {

    $connect = new PDO("mysql:host=localhost; dbname=iadopt", "root", "");

    $data = array();

    // Pagination setup
    $limit = 5;
    $page = $_POST["page"] > 1 ? $_POST["page"] : 1;
    $start = ($page - 1) * $limit;

    // Sanitizing the search query to prevent unwanted characters
    $condition = trim(preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]));

    // Preparing the parameters for the query
    $query_params = [
        ':complete_address' => '%' . $condition . '%',
        ':first_name'       => '%' . $condition . '%',
        ':last_name'        => '%' . $condition . '%',
        ':animal_status'    => '%' . $condition . '%',
        ':animal_name'      => '%' . $condition . '%',
        ':adoption_date'    => '%' . $condition . '%',
    ];

    // SQL query to fetch data
	$query = "
	SELECT applications.application_id, applications.complete_address, users.first_name, users.last_name, 
		   animals.animal_status, animals.name, applications.adoption_date
	FROM applications
	INNER JOIN users ON applications.user_id = users.user_id
	INNER JOIN animals ON applications.animal_id = animals.animal_id
	WHERE (applications.complete_address LIKE :complete_address OR 
		   users.first_name LIKE :first_name OR 
		   users.last_name LIKE :last_name OR 
		   animals.animal_status LIKE :animal_status OR
		   animals.name LIKE :animal_name OR
		   applications.adoption_date LIKE :adoption_date)
	  AND animals.animal_status = 'Adopted'
	  AND applications.application_status = 'Approved'
	ORDER BY applications.application_id DESC
	";	

    // Apply pagination to the query
    $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit;

    // Execute query to get total data and paginated data
    $statement = $connect->prepare($query);
    $statement->execute($query_params);
    $total_data = $statement->rowCount();

    $statement = $connect->prepare($filter_query);
    $statement->execute($query_params);
    $result = $statement->fetchAll();

    // Escape condition and highlight matches
    $escaped_condition = htmlspecialchars($condition, ENT_QUOTES, 'UTF-8');
    $highlighted_condition = '<span style="background-color:#555; color:#fff">' . $escaped_condition . '</span>';

    // Prepare the data for response
    foreach ($result as $row) {
        $data[] = array(
            'application_id'   => $row["application_id"],
            'first_name'       => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["first_name"])),
            'last_name'        => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["last_name"])),
            'animal_status'    => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["animal_status"])),
            'animal_name'      => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["animal_name"])),
            'adoption_date'    => str_ireplace($escaped_condition, $highlighted_condition, htmlspecialchars($row["adoption_date"])),
        );
    }

    // Pagination links
    $pagination_html = '<div align="center"><ul class="pagination">';

    $total_links = ceil($total_data / $limit);
    $previous_link = $page > 1 ? '<li class="page-item"><a class="page-link" href="javascript:load_data_application(`' . $_POST["query"] . '`, ' . ($page - 1) . ')"><</a></li>' : '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';

    $next_link = $page < $total_links ? '<li class="page-item"><a class="page-link" href="javascript:load_data_application(`' . $_POST["query"] . '`, ' . ($page + 1) . ')">></a></li>' : '<li class="page-item disabled"><a class="page-link" href="#">></a></li>';

    $page_links = '';
    for ($count = 1; $count <= $total_links; $count++) {
        $active_class = $page == $count ? ' active' : '';
        $page_links .= '<li class="page-item' . $active_class . '"><a class="page-link" href="javascript:load_data_application(`' . $_POST["query"] . '`, ' . $count . ')">' . $count . '</a></li>';
    }

    $pagination_html .= $previous_link . $page_links . $next_link . '</ul></div>';

    // Send the response as JSON
    echo json_encode([
        'data'       => $data,
        'pagination' => $pagination_html,
        'total_data' => $total_data
    ]);
}
?>
