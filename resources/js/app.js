import './bootstrap';

Echo.channel("sessions")
    .listen("SessionStart", (data) => {
        console.log('event')
        console.log(data)
    })
