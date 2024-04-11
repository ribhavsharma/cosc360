describe('Login Page', () => {
  beforeEach(() => {
      cy.visit('http://localhost/cosc360%20-%20Copy/app/pages/login.php'); 
  });

  it('loads successfully', () => {
      cy.title().should('eq', 'Login');
  });

  it('has a signup form', () => {
      cy.get('.flip-card__back form').should('exist');
  });

 it('can fill out and submit the signup form', () => {
    // Click the switch to flip the card and reveal the signup form
    cy.get('.slider').click({force: true});

    // Filling out the signup form
    cy.get('.flip-card__back form input[name="username"]').type('testuser', {force: true});
    cy.get('.flip-card__back form input[name="email"]').type('testuser@example.com', {force: true});
    cy.get('.flip-card__back form input[name="password"]').type('password', {force: true});
    cy.get('.flip-card__back form button[type="submit"]').click({force: true});
  });

  it('has a login form', () => {
      cy.get('.flip-card__front form').should('exist');
  });

  it('can fill out and submit the login form', () => {
      cy.get('.flip-card__front form input[name="email"]').type('test@example.com');
      cy.get('.flip-card__front form input[name="password"]').type('password');
      cy.get('.flip-card__front form button[type="submit"]').click();

  });

  
});