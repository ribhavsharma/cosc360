// Testing the page admin sees after clicking on the "Users" link in the sidebar.
// Admin should be able to add, edit and delete users.

describe('Admin: users page pest', () => {
  beforeEach(() => {
    cy.visit('https://localhost/cosc360%20-%20Copy/app/pages/login.php'); 
    cy.get('.flip-card__front form input[name="email"]').type('aamir@gmail.com');
    cy.get('.flip-card__front form input[name="password"]').type('12345678');
    cy.get('.flip-card__front form button[type="submit"]').click();
  }); 

  // Note that the user we are adding, deleting or editing is passed through the URL as a query parameter

  it('add user form works', () => {
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=users&action=add")
    cy.contains('Users')

    // Check for expected elements in the form
    cy.get('form').should('exist') 
    cy.get('input[name="username"]').should('exist')
    cy.get('input[name="email"]').should('exist')
    cy.get('input[name="password"]').should('exist') 
    cy.get('input[name="retype_password"]').should('exist') 
    cy.get('select[name="role"]').should('exist') 
    cy.get('input[type="file"]').should('exist') 

    // Fill out and submit the form
    cy.get('input[name="username"]').type('testusernew');
    cy.get('input[name="email"]').type('testusernew@example.com');
    cy.get('select[name="role"]').select('user');
    cy.get('input[name="password"]').type('password');
    cy.get('input[name="retype_password"]').type('password');
    cy.get('button[type="submit"]').click();

  });

  it('edit user form works', () => {
    // Visit the edit user page
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=users&action=edit&id=5");

    // Fill out and submit the form
    cy.get('input[name="username"]').clear().type('newusername');
    cy.get('input[name="email"]').clear().type('newuser@example.com');
    cy.get('select[name="role"]').select('admin');
    cy.get('input[name="password"]').type('newpassword');
    cy.get('input[name="retype_password"]').type('newpassword');
    cy.get('button[type="submit"]').click();

  });

  it('Delete user form works', () => {
    // Visit the delete user page 
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=users&action=delete&id=5");

    // Submit the form
    cy.get('button[type="submit"]').click();
  });

})