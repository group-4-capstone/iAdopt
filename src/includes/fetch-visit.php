<?php
// process_data.php

if (isset($_POST["query"])) {
    $connect = new PDO("mysql:host=localhost;dbname=iadopt", "root", "");

    // Default pagination settings
    $limit = 5;
    $page = isset($_POST["page"]) && $_POST["page"] > 1 ? $_POST["page"] : 1;
    $start = ($page - 1) * $limit;

    // Base query
    $query = "SELECT visit_id, name, group_name, num_pax, purpose, visit_date FROM visit";

    // Search condition
    $condition = '';
    $sample_data = [];
    if ($_POST["query"] !== '') {
        $clean_query = preg_replace('/[^A-Za-z0-9\- ]/', '', trim($_POST["query"]));
        $condition = " WHERE name LIKE :name OR group_name LIKE :group_name";
        $sample_data = [
            ':name' => '%' . str_replace(' ', '%', $clean_query) . '%',
            ':group_name' => '%' . str_replace(' ', '%', $clean_query) . '%'
        ];
    }

    // Total data count query
    $total_query = $query . $condition;
    $statement = $connect->prepare($total_query);
    $statement->execute($sample_data);
    $total_data = $statement->rowCount();

    // Fetch paginated results
    $filter_query = $total_query . " ORDER BY visit_id DESC LIMIT $start, $limit";
    $statement = $connect->prepare($filter_query);
    $statement->execute($sample_data);
    $result = $statement->fetchAll();

    // Highlight search terms
    $replace_array_1 = explode('%', str_replace(' ', '%', $_POST["query"]));
    $replace_array_2 = array_map(function ($term) {
        return '<span style="background-color:#' . rand(100000, 999999) . '; color:#fff">' . $term . '</span>';
    }, $replace_array_1);

    // Format data
    $data = [];
    foreach ($result as $row) {
        $data[] = [
            'visit_id'   => $row["visit_id"],
            'name'       => str_ireplace($replace_array_1, $replace_array_2, $row["name"]),
            'group_name' => str_ireplace($replace_array_1, $replace_array_2, $row["group_name"]),
            'num_pax'    => $row['num_pax'],
            'purpose'    => $row['purpose'],
            'visit_date' => $row['visit_date']
        ];
    }

    // Generate pagination
    $total_links = ceil($total_data / $limit);
    $pagination_html = generate_pagination($total_links, $page, $_POST["query"]);

    // Output
    echo json_encode([
        'data'        => $data,
        'pagination'  => $pagination_html,
        'total_data'  => $total_data
    ]);
}

// Function to generate pagination HTML
function generate_pagination($total_links, $current_page, $query) {
    $pagination = '<div align="center"><ul class="pagination">';
    
    // Previous link
    $previous_page = $current_page - 1;
    $previous_link = $current_page > 1
        ? '<li class="page-item"><a class="page-link" href="javascript:load_data(\'' . $query . '\', ' . $previous_page . ')"><</a></li>'
        : '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';
    $pagination .= $previous_link;
    
    // Page links
    for ($i = 1; $i <= $total_links; $i++) {
        $active_class = $i == $current_page ? ' active' : '';
        $pagination .= '<li class="page-item' . $active_class . '"><a class="page-link" href="javascript:load_data(\'' . $query . '\', ' . $i . ')">' . $i . '</a></li>';
    }
    
    // Next link
    $next_page = $current_page + 1;
    $next_link = $current_page < $total_links
        ? '<li class="page-item"><a class="page-link" href="javascript:load_data(\'' . $query . '\', ' . $next_page . ')">></a></li>'
        : '<li class="page-item disabled"><a class="page-link" href="#">></a></li>';
    $pagination .= $next_link;
    
    $pagination .= '</ul></div>';
    return $pagination;
}
?>
