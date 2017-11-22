<div id="headerwrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>Send your authors
                    <br/>and books to an incredible API</h1>
                <form class="form-inline" role="form" action="/" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" name="file" data-filename-placement="inside" accept=".json" required/>
                        <button type="submit" class="btn btn-warning btn-lg">Send</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <img class="img-responsive" src="assets/img/ipad-hand.png" alt="">
            </div>
        </div>
    </div>
</div>

<div class="container">
        <div class="row mt">
            <h2>An efficient way to send your authors and books to the cloud</h2>
            <p>Please, follow this model to successful upload your authors and books.</p>
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
            
        </div>
    </div>
    