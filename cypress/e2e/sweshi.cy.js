describe('template spec', () => {
  it('passes', () => {

	cy.visit('http://127.0.0.1:8000/');
	cy.get('.min-h-screen').click();
	cy.get('.rounded-md:nth-child(1)').click();
	cy.get('#email').type('test@gmail.com');
	cy.get('#password').type('test@gmail.com');
	cy.get('.min-h-screen').click();
	cy.get('.inline-flex').click();
	cy.get('form').submit();
	cy.get('.inline-flex:nth-child(2)').click();
	cy.get('#search').click();
	cy.get('#search').type('kas');
	cy.url().should('contains', 'http://127.0.0.1:8000/event');

  })
})