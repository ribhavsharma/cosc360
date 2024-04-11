// Testing the admin's categories page 
// Admin should be able to add, edit and delete categories.

describe('Category Page Tests', () => {
  beforeEach(() => {
    cy.visit('https://localhost/cosc360%20-%20Copy/app/pages/login.php'); 
    cy.get('.flip-card__front form input[name="email"]').type('aamir@gmail.com');
    cy.get('.flip-card__front form input[name="password"]').type('12345678');
    cy.get('.flip-card__front form button[type="submit"]').click();
  }); 

  it('add category form works', () => {
    // Visit the add category page
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=categories&action=add");

    // Fill out and submit the form
    cy.get('input[name="category"]').type('TestCategory');
    cy.get('select[name="disabled"]').select('0');
    cy.get('button[type="submit"]').click(); 
  });

  it('edit category form works', () => {
    // Visit the edit category page
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=categories&action=edit&id=3");

    // Fill out and submit the form
    cy.get('input[name="category"]').clear().type('NewTestCategory');
    cy.get('select[name="disabled"]').select('1');
    cy.get('button[type="submit"]').click();
  });

  it('delete category works', () => {
    // Visit the delete category page
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=categories&action=delete&id=7");

    // Submit the form
    cy.get('button[type="submit"]').click(); 
  });
});