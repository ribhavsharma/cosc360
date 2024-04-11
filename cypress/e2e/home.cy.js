describe('Home Page', () => {
  beforeEach(() => {
      cy.visit('http://localhost/cosc360%20-%20Copy/app/public/'); 
  });

  it('loads successfully', () => {
      cy.title().should('eq', 'Home');
  });

  it('has a search form', () => {
      cy.get('form').should('exist');
  });

  it('can fill out and submit the search form', () => {
      cy.get('input[name="search"]').type('test');
      cy.get('select[name="category"]').select('Science');
      cy.get('button[type="submit"]').click();

      // Check that the URL has changed according to the search params
      cy.url().should('include', 'search=test');
      cy.url().should('include', 'category=Science');
  });

  it('has a navigation bar with correct links', () => {
      cy.get('.nav-links a').should('have.length', 2);
      cy.get('.nav-links a').eq(0).should('have.attr', 'href', '../pages/home.php');
      // cy.get('.nav-links a').eq(1).should('have.attr', 'href', '/user.php');
      // cy.get('.nav-links a').eq(2).should('have.attr', 'href', '/admin.php');
      // cy.get('.nav-links a').eq(3).should('have.attr', 'href', '/write.php');
      cy.get('.nav-links a').eq(1).should('have.attr', 'href', '../pages/login.php');
  });

  it('has a slider with correct images and links', () => {
      cy.get('.ism-slider a').should('have.length', 5);
      cy.get('.ism-slider a').eq(0).should('have.attr', 'href', './category.php?category=Nature');
      cy.get('.ism-slider a').eq(1).should('have.attr', 'href', './category.php?category=Science');
      cy.get('.ism-slider a').eq(2).should('have.attr', 'href', './category.php?category=Travel');
      cy.get('.ism-slider a').eq(3).should('have.attr', 'href', './category.php?category=Lifestyle');
      cy.get('.ism-slider a').eq(4).should('have.attr', 'href', './category.php?category=Adventures');
  });

  it('has a posts section', () => {
      cy.get('#posts-section').should('exist');
  });
});