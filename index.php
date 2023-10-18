<?php
require 'person.php';

$person = new Person($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        // Create a new person
        $name = $_POST['name'];
        $age = $_POST['age'];
        $person->createPerson($name, $age);
    } elseif (isset($_POST['update'])) {
        // Update a person
        $id = $_POST['update_id'];
        $name = $_POST['update_name'];
        $age = $_POST['update_age'];
        $person->updatePerson($id, $name, $age);
    } elseif (isset($_POST['delete'])) {
        // Delete a person
        $id = $_POST['delete_id'];
        $person->deletePerson($id);
    }
}

// Read all persons
$persons = $person->readPersons();

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Operations</title>
</head>
<body>
    <h1>CRUD Operations</h1>
    
    <!-- Create Person Form -->
    <h2>Create Person</h2>
    <form method="POST" action="index.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <input type="submit" name="create" value="Create">
    </form>

    <!-- Display Persons -->
    <h2>Persons</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($persons as $person) { ?>
        <tr>
            <td><?php echo $person['id']; ?></td>
            <td><?php echo $person['name']; ?></td>
            <td><?php echo $person['age']; ?></td>
            <td>
                <form method="POST" action="index.php">
                    <input type="hidden" name="update_id" value="<?php echo $person['id']; ?>">
                    <input type="text" name="update_name" placeholder="New Name">
                    <input type="number" name="update_age" placeholder="New Age">
                    <input type="submit" name="update" value="Update">
                </form>
                <form method="POST" action="index.php">
                    <input type="hidden" name="delete_id" value="<?php echo $person['id']; ?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>