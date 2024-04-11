// Testing an admin's dashboard page contains some expected elements.

describe('Admin Dashboard Test', () => {
  beforeEach(() => {
    cy.visit('https://localhost/cosc360%20-%20Copy/app/pages/login.php'); 

    cy.get('.flip-card__front form input[name="email"]').type('aamir@gmail.com');
    cy.get('.flip-card__front form input[name="password"]').type('12345678');
    cy.get('.flip-card__front form button[type="submit"]').click();
  }); 

  it('admin dashboard page loads and has the expected elements', () => {
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=dashboard")

    // Check that the page contains some expected text
    cy.contains('Dashboard')
    cy.contains('Admins')
    cy.contains('Users')
    cy.contains('Categories')
    cy.contains('Posts')

    // Check for specific elements
    cy.get('.navbar').should('exist') 
    cy.get('.sidebar').should('exist') 
    cy.get('.breadcrumb').should('exist') 

    cy.get('button').contains('Share').should('exist')
    cy.get('button').contains('Export').should('exist')

    cy.get('a').contains('Sign out').should('exist')
  })
})