describe('User Page', () => {
    beforeEach(() => {
      cy.visit('https://localhost/cosc360%20-%20Copy/app/pages/login.php'); 
  
      cy.get('.flip-card__front form input[name="email"]').type('test@gmail.com');
      cy.get('.flip-card__front form input[name="password"]').type('test1234');
  
      // Submit login form
      cy.get('.flip-card__front form button[type="submit"]').click();
  
      // Click on the username to go to the user page
      cy.get('nav .nav-links li a').contains('test').click();
    });
  
    it('loads successfully', () => {
        cy.title().should('eq', 'User page');
    });
  
    it('displays user information', () => {
        cy.get('.user h1').should('contain', 'test');
        cy.get('.user-links li').should('have.length', 2);
    });
  
    it('displays posts', () => {
        cy.get('.articles .article').should('have.length.at.least', 0);
        cy.get('.articles .article h2').should('not.be.empty');
        cy.get('.articles .article p').should('not.be.empty');
        cy.get('.articles .article .info ul li').should('not.be.empty');
        cy.get('.articles .article .post-actions a').should('have.length', 2);
    });
  
    it('displays profile', () => {
        cy.get('.profile h3').should('contain', 'test');
        cy.get('.profile a').should('contain', 'Edit profile');
    });
  
    it('has a navigation bar', () => {
      cy.get('nav').should('exist');
      cy.get('nav .nav-links li').should('have.length.at.least', 1);
    });
  
    it('has a header', () => {
        cy.get('header').should('exist');
    });
  
    it('has a working "Edit profile" link', () => {
        cy.get('.name-and-edit a').click();
        cy.url().should('include', 'https://localhost/cosc360%20-%20Copy/app/pages/user.php#');
    });
  
    it('has working "Edit" and "Delete" buttons for posts', () => {
        // Check edit button
        cy.get('.articles .article .post-actions a').contains('Edit').first().click();
        cy.url().should('include', 'https://localhost/cosc360%20-%20Copy/app/pages/editPost.php?id=4');
  
        // Go back to the user page
        cy.visit('https://localhost/cosc360%20-%20Copy/app/pages/user.php');
  
        // Check the delete button and confirmation after clicking
        cy.get('.articles .article .post-actions a').contains('Delete').first().click();
        cy.url().should('include', '/deletePost.php');
    });
  
  });