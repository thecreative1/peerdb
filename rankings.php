<?php
?>
<!-- HTML and PHP Query -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Group Rankings</h3>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Rank</th>
							<th>Grp #</th>
							<th>Av. Rating</th>
						</tr>
					</thead>	
					<?php // Query to retrieve average rating from assessment.group
			
					//gets assessment attributes for all groups
					$sql4 = "SELECT groupID, grade FROM assessment";
					$result4=mysqli_query($conn,$sql4);
					//die(var_dump($result4));

					$counter = [];
					$grades  = [];
					$average = [];

					$number = 1;

					while ($assignment = mysqli_fetch_array($result4)) { 

  						if (!isset($counter[$assignment['groupID']])) {
    						$counter[$assignment['groupID']] = 0;
  						}
  
  						if (!isset($grades[$assignment['groupID']])) {
    					$grades[$assignment['groupID']] = 0;
  						}
  
  					  $counter[$assignment['groupID']]++;
  				      $grades[$assignment['groupID']] += $assignment['grade'];
					}
					//die(var_dump($counter));
					//mysqli_data_seek($result4, 0);
					foreach ($counter as $group_id => $score) {
  					$average[$group_id] = ($grades[$group_id] * 100/($counter[$group_id] * 5));
					}
					//var_dump($counter, $average);

					//array_multisort($average, SORT_DESC, $counter);
					arsort($average);

					//die(var_dump($result4));
					echo '<tbody>';
					foreach ($average as $group_id => $values) {
  					echo '<tr>';
  					echo '<td>' . $number . '</td>';
					//die(var_dump($row));
   					// this will print group ids, lookup could be used as an alternative to show group name
  					echo "<td>" . $group_id . "</td>";
  					// this accesses the variable from averages using the group_id from $row2
 					echo '<td>' . $average[$group_id] . '%</td>';
  					echo '</tr>';

  					$number++;
					}


					echo '</tbody>';

					?>
				</table>
			</div>

			<?php
            //$sql5 = 'select a.commentID, a.groupID, a.grade, a.commentData, c.criteriaData, c.criteriaID from assessment a left join criteria c on a.criteriaID = c.criteriaID';
            $sql6 = 'select a.commentID, a.groupID, a.grade, a.fromGroup, a.commentData, c.criteriaData, c.criteriaID from assessment a left join criteria c on c.criteriaID = a.criteriaID left join student s on s.groupID = a.groupID';
            $result6 = mysqli_query($conn, $sql6);

            $comments = [];

            while ($result = mysqli_fetch_array($result6)) {
              if (!isset($comments[$result['groupID']])) {
              $comments[$result['groupID']]['total_grade'] = 0;
              $comments[$result['groupID']]['total_assessments'] = 0;
              }
              if (!empty($result['fromGroup'])) {
                $comments[$result['groupID']]['fromGroup']=$result['fromGroup'];
              }

              $comments[$result['groupID']]['grades'][$result['commentID']] = $result['grade'];
                $comments[$result['groupID']]['total_assessments']++;
                $comments[$result['groupID']]['comments'][$result['commentID']] = $result['commentData'];
                $comments[$result['groupID']]['total_grade'] += $result['grade'];
              }
              ksort($comments);

            foreach ($comments as $group_id => $values) {
            ?>


          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Grades for Group <?php echo $group_id ?>'s Report</h3>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Grp #</th>
                  <th>Total Grade</th>
                  <th>Criterion 1</th>
                  <th>Criterion 2</th>
                  <th>Criterion 3</th>
                  <th>Criterion 4</th>
                  <th>Criterion 5</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $values['fromGroup'] ?></td>
                  <td><?php echo $values['total_grade'] ?>/<?php echo $values['total_assessments'] * 5 ?></td>
                  <?php foreach ($values['grades'] as $grade) { ?>
                  <td><?php echo $grade ?>/5</td>
                  <?php } ?>
                  <?php for ($i = 0; $i <= (4 - count($values['grades'])); $i++) { ?>
                  <td></td>
                  <?php } ?>
                  </tr>
                  <tr>
                  <td class="comments" colspan="2">Comments</td>
                  <?php foreach ($values['comments'] as $comment) { ?>
                  <td class="comments-text"><?php echo $comment ?></td>
                  <?php } ?>
                  <?php for ($i = 0; $i <= (4 - count($values['comments'])); $i++) { ?>
                  <td></td>
                  <?php } ?>
                </tr>
              </tbody>
            </table>
          </div>
          <?php } ?>
