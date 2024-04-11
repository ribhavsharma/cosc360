// Testing the page user sees when clicking on any post.

describe('Post page test', () => {
  beforeEach(() => {
    cy.visit('https://localhost/cosc360%20-%20Copy/app/pages/login.php'); 
    cy.get('.flip-card__front form input[name="email"]').type('aamir@gmail.com');
    cy.get('.flip-card__front form input[name="password"]').type('12345678');
    cy.get('.flip-card__front form button[type="submit"]').click();
  }); 

  it('add post form works', () => {
    // Visit the add post page
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=posts&action=add");

    // Fill out and submit the form
    cy.get('input[name="title"]').type('TestPost');
    cy.get('textarea[name="content"]').type('This is a test post.');
    cy.get('select[name="category_id"]').select('2');
    cy.get('form input[type="file"]').attachFile('placeholder2.jpg'); 
    cy.get('button[type="submit"]').click();
  });

  it('edit post form works', () => {
    // Visit the edit post page
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=posts&action=edit&id=5");

    // Fill out and submit the form
    cy.get('input[name="title"]').clear().type('NewTestPost');
    cy.get('textarea[name="content"]').clear().type('This is a new test post.');
    cy.get('select[name="category_id"]').select('2');
    cy.get('button[type="submit"]').click();
  });

  it('delete post works', () => {
    // Visit the delete post page
    cy.visit("https://localhost/cosc360%20-%20Copy/app/pages/admin.php?section=posts&action=delete&id=5");

    // Submit the form
    cy.get('button[type="submit"]').click();
  });
});