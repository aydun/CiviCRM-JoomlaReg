# CiviCRM CiviReg plugin

This small plugin retricts user registration so that the email address for the user must be associated with a contact in CiviCRM.

The email address must be the primary address for one living (not deceased) Individual.

## Usage

Install and enable the plugin.

The plugin configuration page allows additional fields to be specified.  This requires some understanding of how the plugin works:

- When the user submits the account creation form, the email address is used to find matching contacts using the 'Contact.get' API call.  Registration is allowed to proceed only if this query returns a single contact record.
- Additional parameters can be passed in JSON format to the API call using the configuration option.  
- For example, to specify that a particular custom field should not be blank, you can enter:
```
{"custom_28":{"NOT LIKE":""}}
```
- Tip: use API explorer to generate the right JSON syntax by looking at the REST line.  Be sure to include the enclosing braces.
