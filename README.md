# Contact Manager API application
### models
-  Contact
- Company
- User
- ContactNote

### Relations

- Contact belongs to User
- Contact belongs to company
- contact has many contact notes
- company has many contacts
- user has many contacts

### Routes
- POST api/auth/login 
    - Parameters: email, password
- POST api/auth/register 
    - Parameters: email, password, name
- GET api/companies (list all companies)
- GET api/companies/{company}/contacts (list company contacts paginated)
- GET api/contacts (list all contacts)
    - Parameters: page, per_page, name, company
- POST api/contacts
   - Parameters: name, phone_number, email
