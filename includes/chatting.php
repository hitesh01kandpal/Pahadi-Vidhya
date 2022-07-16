<?php
include "../includes/config.php";
$id = $_SESSION['user_id'];
$course = $_POST['course_id'];
$courseDiscussion = $course . 'd';
$result =  mysqli_query($conn, "SELECT *  FROM $courseDiscussion where parent_comment='0' ORDER BY id desc");
$html = "";
$html .= '<table class="table" id="MyTable" style="background-color: #edfafa; border-left:1px solid black; border-right:1px solid black">
<tbody id="record">';
while ($res = mysqli_fetch_array($result)) :
  $pid = $res['id'];

  $html .= '<tr style="border-top:1px solid black; border-bottom:1px solid black">
    <tr>';
  $colour = "blue";
  if ($res['role'] == 'teacher' || $res['role'] == 'superAdmin')
    $colour = "red";
  $html .= '<td><b><img src="../images/avatar.jpg" width="30px" height="30px" /><span style="color: ' . $colour . ' ">  ' . $res['student'] . '</span> :<i> ' . $res['date'] . ':</i></b></br>
      <p style="padding-left:40px"><span id="' . $res['id'] . '">' . $res['post'] . '</span></br>
      <div>    
      <button style="float:left; margin-left:20px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#ReplyModal" data-id=' . $res['id'] . ' id="submit" onclick="reply(this)">
            Reply
          </button>';
  if ($res['user_id'] == $id) :
    $html .= '<button style="float:left;" type="button" class="btn btn-link" data-toggle="modal" data-target="#editModal" data-id= ' . $res['id'] . ' id="submit" onclick="edit(this)">
              Edit
            </button>
        <form name="frm4" method="post" action="discussion.php?course=' . $course . '">
          <input type="hidden" id="id" name="id" value=" ' . $res['id'] . '">
          <button style="float:left;" type="submit" class="btn btn-link" name="delete" value="delete">
            Delete
          </button>
        </form>
        </div>';
  endif;
  $html .= '</p>
      </td>
    </tr>';
  $result1 =  mysqli_query($conn, "SELECT *  FROM $courseDiscussion where parent_comment=$pid ORDER BY id");
  while ($res1 = mysqli_fetch_array($result1)) :

    $html .= '<tr>';
    $colour = "blue";
    if ($res1['role'] == 'teacher' || $res1['role'] == 'superAdmin')
      $colour = "red";

    $html .= '<td style="padding-left:80px "><b><img src="../images/avatar.jpg" width="30px" height="30px" /><span style="color: ' . $colour . '">  ' . $res1['student'] . ' </span> :<i>   ' . $res1['date'] . ':</i></b></br>
          <p style="padding-left:40px"><span id="' . $res1['id'] . '"> ' . $res1['post'] . '</span><br>';
    if ($res1['user_id'] == $id) :
      $html .= '<div>
              <button style="float:left; margin-left:20px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#editModal" data-id=' . $res1['id'] . ' id="submit" onclick="edit(this)">
                Edit
              </button>
          <form name="frm5" method="post" action="discussion.php?course=' . $course . '">
            <input type="hidden" id="id" name="id" value="' . $res1['id'] . '">
            <button style="float:left;" type="submit" class="btn btn-link" name="delete" value="delete">
              Delete
            </button>
          </form>
          <div>';
    endif;
    $html .= '</p>
        </td>
      </tr>';
  endwhile;
  $html .= '</tr>';
endwhile;
$html .= '<hr class="horizontal">
  </hr class="horizontal">
</tbody>
</table>';
echo $html;
