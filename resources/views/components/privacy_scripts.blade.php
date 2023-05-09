<script>
    var submitButton = false;
    var articleForm = document.querySelector('form');

    articleForm.addEventListener('submit', (event) => {
        submitButton = true;
    });

    window.addEventListener('beforeunload', (e) => {
        if(submitButton === false)
        {
            e.preventDefault();
            e.returnValue = 'Are you sure you want to exit this page?';
        }
    });

    function countCharactersTitle(obj)
    {
        if(obj.name === 'translations.title.en')
        {
            var maxCharLengthEn = 60;
            var inputStringLengthEn = obj.value.length;

            if(inputStringLengthEn > maxCharLengthEn){
                document.getElementById("titleCharNumEn").innerHTML = '<span style="color: red;">'+inputStringLengthEn+' / '+maxCharLengthEn+' characters.</span>';
            }else {
                document.getElementById("titleCharNumEn").innerHTML = inputStringLengthEn+' / '+maxCharLengthEn+' characters.';
            }
        }

        if(obj.name === 'translations.title.id')
        {
            var maxCharLengthId = 60;
            var inputStringLengthId = obj.value.length;

            if(inputStringLengthId > maxCharLengthId){
                document.getElementById("titleCharNumId").innerHTML = '<span style="color: red;">'+inputStringLengthId+' / '+maxCharLengthId+' characters.</span>';
            }else {
                document.getElementById("titleCharNumId").innerHTML = inputStringLengthId+' / '+maxCharLengthId+' characters.';
            }
        }
    }

    function countCharactersDescription(obj)
    {
        if(obj.name === 'translations.description.en')
        {
            var maxCharLengthEn = 160;
            var inputStringLengthEn = obj.value.length;

            if(inputStringLengthEn > maxCharLengthEn){
                document.getElementById("descCharNumEn").innerHTML = '<span style="color: red;">'+inputStringLengthEn+' / '+maxCharLengthEn+' characters.</span>';
            }else {
                document.getElementById("descCharNumEn").innerHTML = inputStringLengthEn+' / '+maxCharLengthEn+' characters.';
            }
        }

        if(obj.name === 'translations.description.id')
        {
            var maxCharLengthId = 160;
            var inputStringLengthId = obj.value.length;

            if(inputStringLengthId > maxCharLengthId){
                document.getElementById("descCharNumId").innerHTML = '<span style="color: red;">'+inputStringLengthId+' / '+maxCharLengthId+' characters.</span>';
            }else {
                document.getElementById("descCharNumId").innerHTML = inputStringLengthId+' / '+maxCharLengthId+' characters.';
            }
        }
    }

    function countCharactersSEO(obj)
    {
        if(obj.name === 'seoMeta.seo_title.en')
        {
            var maxCharLengthSEOTitleEn = 60;
            var inputStringLengthSEOTitleEn = obj.value.length;

            if(inputStringLengthSEOTitleEn > maxCharLengthSEOTitleEn){
                document.getElementById("titleCharNumSEOTitleen").innerHTML = '<span style="color: red;">'+inputStringLengthSEOTitleEn+' / '+maxCharLengthSEOTitleEn+' characters.</span>';
            }else {
                document.getElementById("titleCharNumSEOTitleen").innerHTML = inputStringLengthSEOTitleEn+' / '+maxCharLengthSEOTitleEn+' characters.';
            }
        }

        if(obj.name === 'seoMeta.seo_title.id')
        {
            var maxCharLengthSEOTitleId = 60;
            var inputStringLengthSEOTitleId = obj.value.length;

            if(inputStringLengthSEOTitleId > maxCharLengthSEOTitleId){
                document.getElementById("titleCharNumSEOTitleid").innerHTML = '<span style="color: red;">'+inputStringLengthSEOTitleId+' / '+maxCharLengthSEOTitleId+' characters.</span>';
            }else {
                document.getElementById("titleCharNumSEOTitleid").innerHTML = inputStringLengthSEOTitleId+' / '+maxCharLengthSEOTitleId+' characters.';
            }
        }
        if(obj.name === 'seoMeta.seo_description.en')
        {
            var maxCharLengthSEODescEn = 160;
            var inputStringLengthSEODescEn = obj.value.length;

            if(inputStringLengthSEODescEn > maxCharLengthSEODescEn){
                document.getElementById("titleCharNumSEODescen").innerHTML = '<span style="color: red;">'+inputStringLengthSEODescEn+' / '+maxCharLengthSEODescEn+' characters.</span>';
            }else {
                document.getElementById("titleCharNumSEODescen").innerHTML = inputStringLengthSEODescEn+' / '+maxCharLengthSEODescEn+' characters.';
            }
        }

        if(obj.name === 'seoMeta.seo_description.id')
        {
            var maxCharLengthSEODescId = 160;
            var inputStringLengthSEODescId = obj.value.length;

            if(inputStringLengthSEODescId > maxCharLengthSEODescId){
                document.getElementById("titleCharNumSEODescid").innerHTML = '<span style="color: red;">'+inputStringLengthSEODescId+' / '+maxCharLengthSEODescId+' characters.</span>';
            }else {
                document.getElementById("titleCharNumSEODescid").innerHTML = inputStringLengthSEODescId+' / '+maxCharLengthSEODescId+' characters.';
            }
        }

        if(obj.name === 'seoMeta.seo_keyword.en')
        {
            var maxCharLengthSEOKeywordEn = 255;
            var inputStringLengthSEOKeywordEn = obj.value.length;

            if(inputStringLengthSEOKeywordEn > maxCharLengthSEOKeywordEn){
                document.getElementById("titleCharNumSEOKeyworden").innerHTML = '<span style="color: red;">'+inputStringLengthSEOKeywordEn+' / '+maxCharLengthSEOKeywordEn+' characters.</span>';
            }else {
                document.getElementById("titleCharNumSEOKeyworden").innerHTML = inputStringLengthSEOKeywordEn+' / '+maxCharLengthSEOKeywordEn+' characters.';
            }
        }

        if(obj.name === 'seoMeta.seo_keyword.id')
        {
            var maxCharLengthSEOKeywordId = 255;
            var inputStringLengthSEOKeywordId = obj.value.length;

            if(inputStringLengthSEOKeywordId > maxCharLengthSEOKeywordId){
                document.getElementById("titleCharNumSEOKeywordid").innerHTML = '<span style="color: red;">'+inputStringLengthSEOKeywordId+' / '+maxCharLengthSEOKeywordId+' characters.</span>';
            }else {
                document.getElementById("titleCharNumSEOKeywordid").innerHTML = inputStringLengthSEOKeywordId+' / '+maxCharLengthSEOKeywordId+' characters.';
            }
        }

    }

</script>
