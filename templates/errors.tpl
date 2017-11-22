<!-- BEGIN VALID -->
<div class='container'>
    <div class='row mt'>
        <h3>
            Please upload a valid json in the following format.
            <pre>
                {
                    "author": [
                        {
                            "firstName": "string",
                            "lastName": "string",
                            "books": [{ "title": "string" },{ "title": "string" }, {...}]
                        },
                        {
                            "firstName": "string",
                            "lastName": "string",
                            "books": [{ "title": "string" }, {...}]
                        }
                    ]
                }
            </pre>
        </h3>
    </div>
</div>
<!-- END VALID -->

<!-- BEGIN CURL -->
<div class='container'>
        <div class='row mt'>
            <h3>
                ERROR: cURL extension not installed
            </h3>
        </div>
    </div>
<!-- END CURL -->

<!-- BEGIN EMPTY -->
<div class='container'>
        <div class='row mt'>
            <h3>
                ERROR: Your uploaded JSON file seems to be empty
            </h3>
        </div>
    </div>
<!-- END EMPTY -->