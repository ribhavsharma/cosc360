$(document).ready(function() {
    // Function to fetch new posts
    function fetchNewPosts() {
        var newestPostId = $('#all-posts-section .post-card:first').data('id');

        $.ajax({
            url: './fetchPosts.php', // URL of the PHP file that fetches new posts
            type: 'GET',
            data: {
                newestPostId: newestPostId
            },
            success: function(data) {
                // Prepend the new posts to the posts section
                $('#all-posts-section').prepend(data);
            }
        });
    }

    // Fetch new posts every 5 seconds
    setInterval(fetchNewPosts, 5000);
});