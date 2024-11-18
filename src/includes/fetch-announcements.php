<?php

//process_data.php

if(isset($_POST["query"]))
{

	$connect = new PDO("mysql:host=localhost; dbname=iadopt", "root", "");

	$data = array();

	$limit = 5;

	$page = 1;

	if($_POST["page"] > 1)
	{
		$start = (($_POST["page"] - 1) * $limit);

		$page = $_POST["page"];
	}
	else
	{
		$start = 0;
	}

	if($_POST["query"] != '')
	{
		$condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]);
		$condition = trim($condition);
		$condition = str_replace(" ", "%", $condition);

		$sample_data = array(
			':title'         => '%' . $condition . '%',
			':description'   => '%' . $condition . '%'
		);

		$query = "
		SELECT * 
		FROM announcements
		INNER JOIN users ON announcements.admin = users.user_id
		WHERE title LIKE :title OR description LIKE :description
		ORDER BY announcement_id DESC
		";


		$filter_query = $query . ' LIMIT ' . $start . ', ' . $limit;

		$statement = $connect->prepare($query);
		$statement->execute($sample_data);
		$total_data = $statement->rowCount();

		$statement = $connect->prepare($filter_query);
		$statement->execute($sample_data);

		$result = $statement->fetchAll();

		$replace_array_1 = explode('%', $condition);
		foreach($replace_array_1 as $row_data)
		{
			$replace_array_2[] = '<span style="background-color:#'.rand(100000, 999999).'; color:#fff">'.$row_data.'</span>';
		}

		foreach($result as $row)
		{
			$data[] = array(
				'announcement_id'     => $row["announcement_id"],
				'title'         => str_ireplace($replace_array_1, $replace_array_2, $row["title"]),
				'description'   => str_ireplace($replace_array_1, $replace_array_2, $row["description"]),
				'image'      => $row['image'],
				'announcement_status'      => $row['announcement_status'],
				'publish_date'   => $row['publish_date'],
				'first_name'         => $row["first_name"],
				'last_name'         => $row["last_name"],
				'announcement_date'   => $row['announcement_date']
			);
		}

	}
	else
	{
		$query = "
		SELECT *
		FROM announcements
		INNER JOIN users ON announcements.admin = users.user_id
		ORDER BY announcement_id DESC
	";

		$filter_query = $query . ' LIMIT ' . $start . ', ' . $limit;

		$statement = $connect->prepare($query);
		$statement->execute();
		$total_data = $statement->rowCount();

		$statement = $connect->prepare($filter_query);
		$statement->execute();

		$result = $statement->fetchAll();

		foreach($result as $row)
		{
			$data[] = array(
				'announcement_id'     => $row["announcement_id"],
				'title'         => $row["title"],
				'description'   => $row["description"],
				'image'      => $row['image'],
				'announcement_status'      => $row['announcement_status'],
				'publish_date'   => $row['publish_date'],
				'first_name'         => $row["first_name"],
				'last_name'         => $row["last_name"],
				'announcement_date'   => $row['announcement_date']
			);
		}

	}

	$pagination_html = '
	<div class="pagination-container">
  		<ul class="pagination">
	';

$total_links = ceil($total_data/$limit);

$previous_link = '';
$next_link = '';
$page_link = '';

if ($total_links > 4) {
    if ($page < 5) {
        for ($count = 1; $count <= 5; $count++) {
            $page_array[] = $count;
        }
        $page_array[] = '...';
        $page_array[] = $total_links;
    } else {
        $end_limit = $total_links - 5;

        if ($page > $end_limit) {
            $page_array[] = 1;
            $page_array[] = '...';
            for ($count = $end_limit; $count <= $total_links; $count++) {
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
    for ($count = 1; $count <= $total_links; $count++) {
        $page_array[] = $count;
    }
}

for ($count = 0; $count < count($page_array); $count++) {
    if ($page == $page_array[$count]) {
        $page_link .= '
			<li><a href="#" class="active">'.$page_array[$count].'</a></li>
		';

        $previous_id = $page_array[$count] - 1;

        if ($previous_id > 0) {
            $previous_link = '<li><a href="javascript:load_data_announcements(`'.$_POST["query"].'`, '.$previous_id.')">&lt;</a></li>';
        } else {
            $previous_link = '
				<li class="disabled">
			        <a href="#">&lt;</a>
			    </li>
			';
        }

        $next_id = $page_array[$count] + 1;

        if ($next_id > $total_links) {
            $next_link = '
				<li class="disabled">
	        		<a href="#">&gt;</a>
	      		</li>
			';
        } else {
            $next_link = '
				<li><a href="javascript:load_data_announcements(`'.$_POST["query"].'`, '.$next_id.')">&gt;</a></li>
			';
        }

    } else {
        if ($page_array[$count] == '...') {
            $page_link .= '
				<li class="disabled">
	          		<a href="#">...</a>
	      		</li>
			';
        } else {
            $page_link .= '
				<li>
					<a href="javascript:load_data_announcements(`'.$_POST["query"].'`, '.$page_array[$count].')">'.$page_array[$count].'</a>
				</li>
			';
        }
    }
}

$pagination_html .= $previous_link . $page_link . $next_link;

$pagination_html .= '
		</ul>
	</div>
';

$output = array(
    'data' => $data,
    'pagination' => $pagination_html,
    'total_data' => $total_data
);

echo json_encode($output);


}

?>
