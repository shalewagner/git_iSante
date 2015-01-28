
This file contains instruction on how to setup billing for the Google Translate API service and how to manage API keys for developers. Following these procedures is currently required by the `make locale` functionality. 

Note that API keys obtained with these instructions should never be checked into the code repository or shared with other people or projects.

SETTING UP API PROJECT/BILLING

This procedure only needs to be done once per project. It must be done by someone who can authorize purchases for the project. 

1. First create an APIs project by following this link https://code.google.com/apis/console/
2. Under the 'Services' tab set the 'Translate API' to ON.
3. Under the 'Team' tab add Google accounts for everyone who will need to manage billing or who will need access to API keys. 
4. Under the 'Billing' tab add appropriate payment information using Google Checkout.
5. Under the 'Quotas' tab for the 'Translate API' set the 'Per-User Limit' to 1,000 characters/second/user and set the 'Billable Limit' to 5,000 characters/day.
6. Let the developers know that they can now create and use API keys at https://code.google.com/apis/console/

CREATING AN API KEY

This process is required for anyone who will need to run `make locale`. In order to create a key you must first be a member of the project created in the 'SETTING UP API PROJECT/BILLING' section. 

1. Visit https://code.google.com/apis/console/ and select the appropriate project. 
2. Under the 'API Access' tab click on the "Create new Server key..." button.
3. In the box enter the public IP address of the machine where `make locale` will be executed from and click the "Create" button.

USING AN API KEY

In order to use the key created in 'CREATING AN API KEY' the environment variable ISANTE_TRANSLATE_KEY must be set to the key value before running `make locale`. If you are developing from a Linux machine with the Bash shell this environment variable can be permanently set by adding a line similar to the following to ~/.bash_profile

export ISANTE_TRANSLATE_KEY="api key value"

If you are worried about others having access to your key then you can restrict access to ~/.bash_profile with the following command. 

chmod og-rwx .bash_profile

Once ~/.bash_profile has been edited you will need to log out and back in again in order to see the change. 
