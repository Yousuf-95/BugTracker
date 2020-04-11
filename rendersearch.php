<?php
/* rendersearch.php generates and returns HTML with search results along with paging controls for AJAX on search.php
 * @parameters:- $_GET['query']- contains the search query.
                 $_GET['pageNumber']- the page number of the search resut that is to be rendered
*/

// Dependency for database connection.
require_once('dbconnect.php');
session_start();

if(!isset($_SESSION['username']))
{
     $_SESSION['error'] = 'noaccess';
     header("Location:login.php");
}

//Displayd and error message if the $_GET['query'] isn't provided or is empty.
if( (!isset($_GET['query']) ) || (strlen($_GET['query'])==0) )
{
  die("<div class='result'>Please Enter a Query</div>");
}
$dbconnection = new dbconnector;
$dbconnection->connect();
$rows = $dbconnection->search($_GET['query']);

//Assumes that the pageNumber to be rendered is 1 if $_GET['pageNumber'] isn't provided
if(!isset($_GET['pageNumber']))
{
  $pageNumber = 1;
}
else
{
  $pageNumber = $_GET['pageNumber'];
}

//Defines the number of search results to be displayed per page
$perPageCount = 5;
$count = 0;
$num_matches = count($rows);
//Calculates the number of pages the search results have to be divided in
$pagesCount = ceil($num_matches/$perPageCount);
//Calculates the particular result number from where the results are to be displayed on the current page
$lowerLimit = ($pageNumber - 1) * $perPageCount;

if($num_matches > 0){

  //Renders HTML for number of results as defined in $perPageCount, stops if the end of the query results is reached
  for($i = $lowerLimit; ($i < $num_matches)&&($count < $perPageCount); $i++, $count++) {
    $row = $rows[$i];
    $post = $row['description'];
    //Displays Issue Title with link to the post age and the Description of the issue upto 300 chars
    $description_len = strlen($post);
    $index_lim = $description_len < 300 ? $description_len - 1 : 299;
    $link = 'post.php?post_id='.$row['post_id'];
    echo "<div class='card mb-2'>";
    echo "<div class='card-header bg-dark'><a class='text-white' href='".$link."'>".$row['title']."</a></div>";
    echo "<div class='card-body'>";
    // echo "<a href='".$link."'>".$row['title']."</a>";
    echo "<p class = 'res-desc'>".substr($post, 0, $index_lim)."...</p>";
    echo "</div>";
    echo "</div>";
  }
}

//Message when no matching results are found
else {
  echo "<div class='result'>";
  echo "No Matching Issues Found";
  echo "</div>";
}
?>

<!-- The navigation panel for paging, display of total number of pages and the current page with link to other pages -->
<div style="height: 30px;"></div>
<table class ="searchnav" width="50%" align="center">
    <tr>
      <td valign="top" align="center">
        <?php
        for ($i = 1; $i <= $pagesCount; $i++) {
          if ($i == $pageNumber) {
            echo '<a href="javascript:void(0);" class="current mx-2">';
            echo $i.'</a>';
          }
          else {
            echo '<a href="javascript:void(0);" class="pages" onclick="showRecords('.$perPageCount.','.$i.');">';
            echo $i.'</a>';
          }
        }
?>
      </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td align="center" valign="top">Page <?php echo $pageNumber; ?>
        of <?php echo $pagesCount; ?>
      </td>
    </tr>
    <tr><td><br></td></tr>
</table>
