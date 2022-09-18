<?php
include '/backend/connection.php';
$user_id = $_SESSION['user_id'];
$user = $getFromUser->userData( $user_id );

if ( $getFromUser->loggedIn() === false ) {
    header( 'Location: '.BASE_URL.'index.php' );
}

if ( isset( $_POST['tweet'] ) ) {
    $status = $getFromUser->checkInput( $_POST['status'] );
    $tweet_image = '';

    if ( !empty( $status ) or !empty( $_FILES['file']['name'][0] ) ) {
        if ( !empty( $_FILES['file']['name'][0] ) ) {
            $tweet_image = $getFromUser->uploadImage( $_FILES['file'] );
        }

        if ( strlen( $status ) > 280 ) {
            $error = 'The text of your tweet is too long';
        }
        $tweet_id = $getFromUser->create( 'tweets', array( 'status' => $status, 'tweet_by' => $user_id, 'tweet_image' => $tweet_image) );

        header( 'Location: home.php' );
    } else {
        $error = 'Type or choose image to tweet';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Twitter Clone</title>
    <title>Twitter Clone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Roboto:wght@400;500;700;900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <script src="script.js"></script>
  </head>
  <body>
    <!-- Start of webpage wrapper -->
    <div class="page-wrapper">
      <!-- Start of top nav -->
      <div class="top-nav">
        <div
          class="top-nav-pp"
          onclick="addClass('.sidebar-container','show'), removeClass('.mask-sidebar-container', 'hide')"
        >
          <img src="./Images/blank_pp.png" alt="profile picture" />
        </div>
        <div class="arrow hide" onclick="window.location.href = 'index.html';">
          &#8592;
        </div>
        <h5>Home</h5>
        <div class="search-bar hide">
          <div class="search-pic-container">
            <img src="./Images/search.png" alt="search logo" />
          </div>
          <label for="search"></label>
          <input
            type="text"
            id="search"
            autocomplete="off"
            placeholder="Search Twitter"
            onclick="removeClass('.top-nav .arrow', 'hide'); addClass('.top-nav .top-nav-pp', 'hide')"
          />
        </div>
      </div>
      <!-- End of top nav -->

      <!-- on sidebar open, darken screen -->
      <div class="mask-sidebar-container hide"></div>
      <!------------------------------------>

      <!-- Start of sidebar menu -->
      <div class="sidebar-container">
        <div class="close-sidebar">
          <div
            class="close-popup-container"
            onclick="removeClass('.sidebar-container', 'show'), addClass('.mask-sidebar-container', 'hide')"
          >
            <div class="close-popup"></div>
          </div>
        </div>
        <!-- Start of sidebar content -->
        <div class="sidebar-content">
          <!-- Start of sidebar info -->
          <section class="sidebar-info">
            <div class="sidebar-pp">
              <img src="<?php echo $user->profileImage; ?>" alt="profile picture" />
            </div>
            <div class="name">Name</div>
            <div class="username">@username</div>
            <div class="follows">255 followings 232 followers</div>
          </section>
          <!-- End of sidebar info -->
          <section class="sidebar-menu sidebar-profile">
            <div class="sidebar-profile-pp">
              <img src="./Images/blank_pp.png" alt="profile picture" />
            </div>
            <p>Profile</p>
          </section>
          <section class="sidebar-menu sidebar-logout">
            <div class="sidebar-logout">
              <p>Log out</p>
            </div>
          </section>
        </div>
        <!-- End of sidebar content -->
      </div>
      <!-- End of sidebar menu -->

      <!-- Start of bottom nav -->
      <div class="bottom-nav">
        <div class="bottom-nav-pp twitter-icon hide">
          <img src="./Images/twitter-logo.png" alt="twitter icon" />
        </div>
        <div class="bottom-nav-content" onclick="window.location.href = 'index.html';">
          <div class="bottom-nav-pp home.icon">
            <img src="./Images/home.png" alt="home icon" />
          </div>
          <h2>Home</h2>
        </div>
        <div class="bottom-nav-content" onclick="removeClass('.search-bar', 'hide'); addClass('.top-nav h5', 'hide')">
          <div class="bottom-nav-pp search-icon">
            <img src="./Images/search.png" alt="search icon" />
          </div>
          <h2>Explore</h2>
        </div>
        <div class="bottom-nav-content" onclick="window.location.href = 'profile.html';">
          <div class="bottom-nav-pp profile-icon hide"">
          <img src="./Images/blank_pp.png" alt="blank profile icon" />
          </div>
          <h2>Profile</h2>
        </div>
        <div class="bottom-nav-pp bottom-nav-tweet hide" onclick="removeClass('.tweet-page', 'hide')">
        <img src="./Images/tweet-feather.png" alt="tweet icon" />
        </div>
        <div class="bottom-nav-content nav-signout" onclick="toggleClass('.tooltiptext', 'visible')">
          <div class="tooltiptext">Sign out</div>
          <div class="bottom-nav-pp signout-icon hide">
            <img src="./Images/blank_pp.png" alt="blank profile icon" /></div>
            <div class="bottom-nav-names">
              <h2>Name</h2>
              <h3>@Username</h3>
            </div>
            <h2 class="nav-dots">...</2>
        </div>
      </div>
      <!-- End of bottom nav -->
      <!-- Start of feed -->
      <div class="feed-tweet tweet-container">
        <div class="feed-tweet-pp tweet-pp">
          <img src="<?php echo $user->profileImage; ?>" alt="profile pic" />
        </div>
        <div class="tweet-content">
          <textarea
            class="tweet-text"
            oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'
            rows="3"
            placeholder="What's happening?"
          ></textarea>
          <div class="feed-actions">
            <div class="image-icon">
              <img src="./Images/image-icon.png" alt="image icon" />
            </div>
            <button class="tweet-btn">Tweet</button>
          </div>
          <div class="tweet-content-break"></div>
          <div>
            <?php $getFromTweet->tweets( $user_id);
            ?>
          </div>
        </div>
      </div>
      <!-- End of feed -->
      <!-- Start of right side nav -->
      <div class="right-sidebar">
        <div class="sidebar-search-bar search-bar">
          <div class="search-pic-container">
            <img src="./Images/search.png" alt="search logo" />
          </div>
          <label for="search"></label>
          <input
            type="text"
            id="search"
            autocomplete="off"
            placeholder="Search Twitter"
          />
        </div>
        <div class="right-sidebar-footer">
          <a href="#" class="links resource-links">Terms of Service </a>
          <a href="#" class="links resource-links">Privacy Policy </a>
          <a href="#" class="links resource-links">Cookie Policy </a>
          <a href="#" class="links resource-links">Accessibility </a>
          <a href="#" class="links resource-links">Ads info </a>
          <a href="#" class="links resource-links">More... </a>
          <div class="login-copyright">© 2022 Twitter, Inc.</div>
        </div>
      </div>
      <!-- End of right side nav -->
      <!-- Start tweet icont -->
      <div class="tweet-icon" onclick="removeClass('.tweet-page', 'hide')">
        <img src="./Images/tweet.png" alt="tweet icon" />
      </div>
      <!-- End tweet icon -->
      <!-- Start of tweet page -->
      <div class="tweet-page hide">
        <div class="tweet-nav">
          <div class="left-arrow" onclick="window.location.href = 'index.html';">
            &#8592;
          </div>
          <button class="tweet-btn">Tweet</button>
        </div>
        <div class="tweet-container">
          <div class="tweet-pp">
            <img src="./Images/blank_pp.png" alt="profile pic" />
          </div>
          <div class="tweet-content">
            <textarea
              class="tweet-text"
              oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'
              rows="3"
              placeholder="What's happening?"
            ></textarea>
            <div class="tweet-content-break"></div>
            <div class="image-icon">
              <img src="./Images/image-icon.png" alt="image icon" />
            </div>
          </div>
        </div>
      </div>
      <!-- End of tweet page -->
    </div>
    <!-- End of webpage wrapper -->
  </body>
</html>