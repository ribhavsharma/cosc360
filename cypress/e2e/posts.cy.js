describe('Posts Page', () => {
  beforeEach(() => {
      cy.visit('https://localhost/cosc360%20-%20Copy/app/pages/login.php'); 

      cy.get('.flip-card__front form input[name="email"]').type('test@gmail.com');
      cy.get('.flip-card__front form input[name="password"]').type('test1234');

      cy.get('.flip-card__front form button[type="submit"]').click();

      // Click on the "Blogs" link to go to the blogs page
      cy.get('nav .nav-links li a').contains('Blogs').click();

      // Then on the first blog post to go to the post page
      cy.get('div.col-md-6').first().click();
  });

  // Post content exists
  it('displays post content', () => {
      cy.get('.post').should('exist');
      cy.get('.post h1').should('not.be.empty');
      cy.get('.post img').should('exist');
      cy.get('.post .content').should('not.be.empty');
  });

  // Comments section exists
  it('displays comments', () => {
      cy.get('.comments').should('exist');
      cy.get('.comments h3').should('contain', 'Comments');
      cy.get('.comments form').should('exist');
      cy.get('.comments form textarea[name="content"]').should('exist');
      cy.get('.comments form button[type="submit"]').should('exist');
  });

  // Allows adding a comment
  it('submits a comment', () => {
      cy.get('.comments form textarea[name="content"]').type('Test comment');
      cy.get('.comments form button[type="submit"]').click();

      // Check that the comment was added
      cy.get('.comments.mt-4.container .card.mb-3.w-100 .card-body .card-text').first().should('contain', 'Test comment');
  });
});