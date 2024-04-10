describe('Write Blog Page', () => {
  beforeEach(() => {
      cy.visit('https://localhost/cosc360%20-%20Copy/app/pages/login.php'); 

      cy.get('.flip-card__front form input[name="email"]').type('test@gmail.com');
      cy.get('.flip-card__front form input[name="password"]').type('test1234');

      cy.get('.flip-card__front form button[type="submit"]').click();

      // Click on the "Write Blog" link to go to the write blog page
      cy.get('nav .nav-links li a').contains('Write Blog').click();
  });

  it('loads successfully', () => {
      cy.title().should('eq', 'Home');
  });

  it('displays write blog form', () => {
      cy.get('form').should('exist');
      cy.get('form input[name="title"]').should('exist');
      cy.get('form textarea[name="content"]').should('exist');
      cy.get('form select[name="category_id"]').should('exist');
      cy.get('form input[type="file"]').should('exist');
      cy.get('form button[type="submit"]').should('exist');
  });

  it('submits the form', () => {
      cy.get('form input[name="title"]').type('Test Title');
      cy.get('form textarea[name="content"]').type('Test content');
      cy.get('form select[name="category_id"]').select('1'); 
      cy.get('form input[type="file"]').attachFile('placeholder2.jpg'); 
      cy.get('form button[type="submit"]').click();

      cy.url().should('include', 'https://localhost/cosc360%20-%20Copy/app/pages/home.php');
  });
});