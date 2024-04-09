$(document).ready(function() {
    // Function to fetch new posts
    function fetchNewPosts() {
        if($('input[name="search"]').val() === '' && $('select[name="category"]').val() === '') {
            $.ajax({
                url: './fetchPosts.php', // URL of the PHP file that fetches new posts
                type: 'GET',
                success: function(data) {
                    // Update the posts on the page
                    $('#posts-section').html(data);
                }
            });
        }
    }

    // Fetch new posts every 5 seconds
    setInterval(fetchNewPosts, 5000);
});