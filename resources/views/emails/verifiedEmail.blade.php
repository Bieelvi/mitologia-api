@include('components.link')

<body class="bg-dark">
    <section>
        <div>
            Hello, {{ $user->getNickname() }}!
        </div>
        <div>
            Thanks for signing up for Mythology. To complete your registration <a href="#">Click Here</a> to confirm your email.
        </div>
    </section>

    @include('components.msgError')
    @include('components.msg') 
</body>