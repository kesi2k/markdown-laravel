Submit markdown in the form at endpoint on your localhost 'http://127.0.0.1:8000/markdown/create'

    This sample markdown input:

    # Header one

    Hello there

    How are you?
    What's going on?

    ## Another Header

    This is a paragraph [with an inline link](http://google.com). Neat, eh?

    ## This is a header [with a link](http://yahoo.com)

should result in:

    <h1>Header one</h1>
    
    <p>Hello there</p>
    
    <p>How are you?
    What's going on?</p>
    
    <h2>Another Header</h2>
    
    <p>This is a paragraph <a href="http://google.com">with an inline link</a>. Neat, eh?</p>
    
    <h2>This is a header <a href="http://yahoo.com">with a link</a></h2>
