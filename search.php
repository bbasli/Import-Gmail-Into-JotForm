<?php
include_once "header.html";
session_start();

if (isset($_POST['send'])) {
    $_SESSION['searchType'] = $_POST['search'];
    $_SESSION['searchedText'] = $_POST['searchedText'];
    header('Location: gmailAPI.php');
}
else if (isset($_POST['skip']))
    header('Location: gmailAPI.php');

?>
    <form method="post" id="searchForm">
        <h2>Submission Filtering</h2>
        <div class="searchField">
            <label>Filter by</label>
            <select name="search">
                <option value="subject">Email Subject</option>
                <option value="address">Sender Address</option>
                <option value="name">Sender Name</option>
            </select>
        </div>
        <div class="searchField">
            <label>Search:</label>
            <input type="text" name="searchedText" placeholder="e.g username"/>
        </div>
        <div class="searchField submit">
            <input type="submit" name="send" value="FILTER">&nbsp
            <input type="submit" name="skip" value="SKIP"/>
        </div>
    </form>
<?php
include_once "footer.html";