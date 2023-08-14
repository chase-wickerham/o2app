<?php

ini_set('display_errors', 1);

require 'db_connection.php';
session_start();

// Redirect to the login page if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

// Check if the user ID is set in the session
if (isset($_SESSION['sessuserid'])) {
    $userid = $_SESSION['sessuserid'];
    
    // Fetch user details using a single query
    $stmt = $mysqli->prepare("SELECT tagline, created, avatar FROM users WHERE userid = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $tagline = $user['tagline'];

        $date = new DateTime($user['created']);
        $displayDate = $date->format('F j, Y');

        $avatar_value = $user['avatar'];
        $avatar_image_path = "images/users/" . $avatar_value . ".jpg";
    } else {
        echo "No user data fetched from the database!";
    }

    $stmt->close();
} else {
    echo "Session User ID is not set!";
}

?>



<!--- UI elements are reverse-engineered from a free bootstrap dashboard found here: https://demos.wrappixel.com/free-admin-templates/bootstrap/materialpro-bootstrap-free/html/index.html --->
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Application Application Dashboard</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="css/styleui.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #navbarSupportedContent{
            flex-direction:row-reverse;
        }
        @media only screen and (min-width: 1170px)  {
        #newPostPanel{
         margin-left: 250px; margin-top: 30px;
        }
        #aboutPanel{
         margin-left: 250px; margin-top: 30px;
        }
        }
        .topbar{
            background:#6293b8;
        }
    </style>

</head>

<body>
    <!---Preloader plugin kept from the template --->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!---Main Wrapper---->
    <div id="main-wrapper" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="navbar-brand ms-4" href="dashboard.php">
                        <span class="logo-text">
                            <img src="applogo2.png" alt="homepage" style="max-width:150px;" />
                        </span>
                    </a>
                    <!-- toggle and nav items -->
                    <a class="nav-toggler waves-effect waves-light text-white d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-lg-none d-md-block ">
                        <li class="nav-item">
                            <a class="nav-toggler nav-link waves-effect waves-light text-white "
                                href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                        </li>
                    </ul>
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" style="cursor:default;" href="dashboard.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo "<img src='" . $avatar_image_path . "' alt='User Avatar' class='profile-pic me-2'>"; ?>
                            <?php echo isset($_SESSION['sessusername']) ? $_SESSION['sessusername'] : 'Guest'; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown"></ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left Sidebar -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">

                    <li class="text-center p-20"> <a href="#" id="newPostButton" style="min-width:105px;" class="btn btn-newpost text-white mt-4 mb-4" target="_blank">+ New Post</a>
                        </li>

                        <li id="dashboardLink" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="dashboard.php" aria-expanded="false"><i class="mdi me-2 mdi-gauge"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li id="profileLink" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="#" aria-expanded="false">
                                <i class="mdi me-2 mdi-account-check"></i><span class="hide-menu">Profile</span></a>
                        </li>
                        <li id="graphsLink" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="#" aria-expanded="false"><i class="mdi me-2 mdi-chart-pie"></i><span
                                    class="hide-menu">Graphs</span></a></li>
                        <li id="myPostsLink" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="#" aria-expanded="false"><i
                                    class="mdi me-2 mdi-book-open-variant"></i><span class="hide-menu">My Posts</span></a>
                        </li>
                        <li id="aboutLink" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="#" aria-expanded="false"><i class="mdi me-2 mdi-help-circle"></i><span
                                    class="hide-menu">About</span></a>
                        </li>

                        <li class="text-center p-20 mt-2"> <a href="logout.php" style="min-width:105px;" class="btn btn-danger text-white mt-2" target="_blank">Logout</a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
        </aside>
        <!-- End Left Sidebar   -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-------------MAIN DASHBOARD PANEL----------- -->
            <div class="container-fluid" id="mainDashboard">

                <?php

// Most Recent Posts Display for Main Dashboard
$query = "SELECT posts.*, users.username, users.avatar 
         FROM posts 
         JOIN users ON posts.user_id = users.userid 
         ORDER BY posts.created_at DESC LIMIT 10";

$result = $mysqli->query($query);

if($result) {
    while($post = $result->fetch_assoc()) {
        //styled bootstrap HTML for each post
        echo '<div class="row">';
        echo '<div class="col-lg-10 col-xlg-12">';
        echo '<div class="card">';
        echo '<div class="tab-content">';
        echo '<div class="card-body">';
        echo '<div class="profiletimeline border-start-0">';
        echo '<div class="sl-item">';
        
        // Display the avatar and username
        echo '<div class="sl-left">';
        echo "<img src='images/users/" . htmlspecialchars($post['avatar'], ENT_QUOTES, 'UTF-8') . ".jpg' alt='user' class='img-circle'>"; 
        echo '</div>'; 
        
        // Display date of post less annoyingly
        echo '<div class="sl-right">';
        echo '<div>';
        echo "<a href='#'>" . htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8') . "</a> ";
        echo "<span class='sl-date'>" . date("F j, Y, g:i a", strtotime($post['created_at'])) . "</span>"; 
        
        // Display the post title and content
        echo "<h2 class='mt-2 mb-2'>" . htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') . "</h2>";
        echo "<p class='mt-2'>" . htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8') . "</p>";
        
        echo '</div>'; // end of inner div
        echo '</div>'; // end of sl-right
        
        echo '</div>'; // end of sl-item
        echo '</div>'; // end of profiletimeline
        echo '</div>'; // end of card-body
        echo '</div>'; // end of tab-content
        echo '</div>'; // end of card
        echo '</div>'; // end of col
        echo '</div>'; // end of row
    }
    $result->free();
} else {
    echo "Error fetching recent posts.";
}
?>

<!---MYPOSTS PANEL CONTAINER------->
            </div>
            <div class="container-fluid" id="myPostsPanel" style="display:none;">

            </div>
<!-- PROFILE CHANGE PANEL-->
                <div id="profileCard" class="container-fluid" style="display:none;">
                <div class="row mt-5">
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body profile-card">
                                <center class="mt-4"> 
                                <?php echo "<img src='" . $avatar_image_path . "' class='rounded-circle' width='150' />"; ?>
                                    <h4 class="card-title mt-2"><?php echo isset($_SESSION['sessusername']) ? $_SESSION['sessusername'] : 'Guest'; ?></h4>
                                    <h6 class="card-subtitle">"<?php echo htmlspecialchars($tagline, ENT_QUOTES, 'UTF-8');?>"</h6>
                                    <h6 class="card-subtitle"><?php echo "User Since " . $displayDate; ?></h6>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <form id="form-updateProfile" class="form-horizontal form-material mx-2">
                                    <div class="form-group">
                                        <label class="col-md-12 mb-0">Display Name</label>
                                        <div class="col-md-12">
                                            <input type="text" name="display_name" placeholder="<?php echo isset($_SESSION['sessusername']) ? $_SESSION['sessusername'] : 'Guest'; ?>"
                                                class="form-control ps-0 form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" name="user_email" placeholder="<?php echo isset($_SESSION['sessuseremail']) ? $_SESSION['sessuseremail'] : 'johndoe@email.com'; ?>"
                                                class="form-control ps-0 form-control-line" name="example-email"
                                                id="example-email">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 mb-0">Tagline</label>
                                        <div class="col-md-12">
                                            <input type="text" name="tagline" placeholder="<?php echo htmlspecialchars($tagline, ENT_QUOTES, 'UTF-8'); ?>"
                                                class="form-control ps-0 form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Select Avatar</label>
                                        <div class="col-sm-12 border-bottom">
                                            <select name="avatar" class="form-select shadow-none ps-0 border-0 form-control-line">
                                                <option value="<?php echo htmlspecialchars($avatar_value, ENT_QUOTES, 'UTF-8'); ?>">Choose Color:</option>
                                                <option value="1">Greenbot</option>
                                                <option value="2">Bluebot</option>
                                                <option value="3">Yellowbot</option>
                                                <option value="4">Purplebot</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 d-flex">
                                            <button type="submit" class="btn btn-success mx-auto mx-md-0 text-white">Update
                                                Profile</button>
                                        </div>
                                    </div>
                                </form>


                                <div class="mx-2 col-sm-12 d-flex">
                                        <button id="changePasswordBtn" class="btn btn-success mx-auto mx-md-0 text-white">Update
                                                Password</button>
                                        </div>
                                <div id="passwordResetForm" style="display:none; margin-top:10px;">
                                     <input style="border: 1px solid #bdbdbd; border-radius: 4px; height: 36px;" type="password" id="currentPassword" placeholder="Current Password">
                                     <input style="border: 1px solid #bdbdbd; border-radius: 4px; height: 36px;" type="password" id="newPassword" placeholder="New Password">
                                     <input style="border: 1px solid #bdbdbd; border-radius: 4px; height: 36px;" type="password" id="confirmNewPassword" placeholder="Confirm New Password">
                                     <button class="btn btn-primary mx-auto mx-md-0 text-white" id="updatePasswordBtn">Update Password</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
<!-- END PROFILE CHANGE PANEL -->

<?php

//Gathering the Top 5 Posters by post count from the database for the Graphs Section
$query = "
SELECT users.username, COUNT(posts.post_id) as post_count 
FROM users 
JOIN posts ON users.userid = posts.user_id 
GROUP BY users.username 
ORDER BY post_count DESC 
LIMIT 5
";

$result = $mysqli->query($query);

if (!$result) {
die("Query failed: " . $mysqli->error);
}

$usernames = [];
$post_counts = [];

while($row = $result->fetch_assoc()) {
$usernames[] = $row['username'];
$post_counts[] = $row['post_count'];
}
?>

<!-- GRAPHS PANEL-->
<div id="graphsPanel" class="container-fluid" style="display:none;">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <canvas id="myChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
</div>
<!-- END GRAPHS PANEL -->

<!-- ABOUT PANEL-->
<div id="aboutPanel" class="container-fluid" style="display:none;">
<div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-body">
                             <p>Hi o2. This is a forum built with basic php with mysqli, javascript, and css bootstrap.</p>
                             <p>The database contains a few tables for containing user data and preferences, and for post data.</p>
                             <p>The main dashboard cross-references these tables to create a feed of the ten most recent posts.</p>
                            </div>
                        </div>
                    </div>
</div>
</div>
<!-- END ABOUT PANEL -->

<!-- NEW POST PANEL-->
<div id="newPostPanel" class="container-fluid" style="display:none;">
                    <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <form id="form-newPost" class="form-horizontal form-material mx-2">
                                    <div class="form-group">
                                        <label class="col-md-12 mb-0">Post Title:</label>
                                        <div class="col-md-12">
                                            <input type="text" name="display_name" placeholder="My Post Title"
                                                class="form-control ps-0 form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 mb-0">Content:</label>
                                        <div class="col-md-12">
                                            <textarea style="height: 150px; padding-top: 10px;" name="postContent" placeholder="Post Content Here" class="form-control ps-0 form-control-line"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12">Attach Optional Graph</label>
                                        <div class="col-sm-12 border-bottom">
                                            <select name="usersGraphsSelection" class="form-select shadow-none ps-0 border-0 form-control-line">
                                                <option value="0">Select:</option>
                                                <option value="1">January Report</option>
                                                <option value="2">February Report</option>
                                                <option value="3">Pageviews Chart</option>
                                                <option value="4">Financials Breakdown</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12 d-flex">
                                            <button type="submit" class="btn btn-success mx-auto mx-md-0 text-white">Submit Post</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
<!-- END NEW POST PANEL -->

          <footer class="footer text-center" style="height: 60px;">
          © 2023 
          <a href="http://chasewickerham.com/">chasewickerham.com </a>
        </footer>
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
    <script>
$(document).ready(function() {
    // Toggle dashboard panels from sidebar links
    $('#profileLink, #newPostButton, #graphsLink, #aboutLink').click(function(e) {
        e.preventDefault();

        // Hide all container panels
        $('.container-fluid').hide();
        let targetId;
        switch ($(this).attr('id')) {
            case 'profileLink':
                targetId = '#profileCard';
                break;
            case 'newPostButton':
                targetId = '#newPostPanel';
                break;
            case 'graphsLink':
                targetId = '#graphsPanel';
                break;
            case 'aboutLink':
                targetId = '#aboutPanel';
                break;
        }
        // Show the active panel
        $(targetId).show();
    });

    // Profile Update Button
    $('#form-updateProfile, #form-newPost').on('submit', function(e) {
        e.preventDefault();

        let actionUrl;
        if ($(this).attr('id') === 'form-updateProfile') {
            actionUrl = 'update_profile.php';
        } else {
            actionUrl = 'submit_post.php';
        }

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
                location.reload();
            }
        });
    });

    // Open Password Reset Form
    $("#changePasswordBtn").click(function() {
        $("#passwordResetForm").slideDown();
    });

    // Update password button
    $("#updatePasswordBtn").click(function(e) {
        e.preventDefault();

        const currentPassword = $("#currentPassword").val();
        const newPassword = $("#newPassword").val();
        const confirmNewPassword = $("#confirmNewPassword").val();

        if (newPassword !== confirmNewPassword) {
            alert("New passwords do not match!");
            return;
        }

        $.ajax({
            type: "POST",
            url: "update_password.php",
            data: {
                currentPassword: currentPassword,
                newPassword: newPassword
            },
            success: function(response) {
                alert(response);
                if (response === "Password updated successfully!") {
                    $("#passwordResetForm").slideUp();
                }
            }
        });
    });

    // Fetch posts when "My Posts" link is clicked
    $("#myPostsLink").on("click", function(e) {
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "fetch_my_posts.php",
            success: function(data) {
                $(".container-fluid").hide();
                $("#myPostsPanel").show().html(data);
            }
        });
    });

    // Delete Post button
    $("#myPostsPanel").on("click", ".deletePostButton", function() {
        let postId = $(this).data("postid");

        $.ajax({
            type: "POST",
            url: "delete_post.php",
            data: { postId: postId },
            success: function(data) {
                alert(data);
                $("#myPostsLink").trigger("click");
            }
        });
    });
});
</script>
<script>
//Example Charts on Graphs page
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($usernames); ?>,
      datasets: [{
        label: 'Top Five Posters by Number of Posts',
        data: <?php echo json_encode($post_counts); ?>,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
  const ctx2 = document.getElementById('myChart2');

  new Chart(ctx2, {
    type: 'pie',
    data: {
      labels: ['Not Pacman', 'Pacman'],
      datasets: [{
        label: 'Ghosts Eaten',
        data: [3, 19],
        backgroundColor: [
      'rgb(228, 228, 228)',
      'rgb(255, 205, 86)'
    ],
    hoverOffset: 4
      }]
    },
  });
</script>
</body>
</html>