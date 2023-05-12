<?php


$conn = new mysqli('localhost', 'root', '', 'dummy_user_management_system');
$result = $conn->query('SELECT * FROM users');
?>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Mobile</th>
      <th>Verified</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['mobile']; ?></td>
        <td><?php echo $row['verified'] ? 'Verified' : 'Not Verified'; ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
