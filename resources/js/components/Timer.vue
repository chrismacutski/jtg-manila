<template>
    <div class="d-md-flex align-items-md-center jtg-animate">
        <div class="countdown-wrap">
            <p class="countdown d-flex">
                <span>{{ days | twoDigits  }} <small>DAYS</small></span>
                <span class="pl-4">{{ hours | twoDigits }} <small>HOURS</small></span>
                <span class="pl-4">{{ minutes | twoDigits }} <small>MINUTES</small></span>
                <span class="pl-4">{{ seconds | twoDigits }} <small>SECONDS</small></span>
            </p>
        </div>
        <a :href="'/events/' + event.id" class="btn btn-transparent p-3">LEARN MORE</a>
    </div>
</template>
<script>
    export default {
        props : {
            date : {
                type: Number,
                coerce: str => Math.trunc(Date.parse(str) / 1000)
            },
            event : Object
        },

        data() {
            return {
                now: Math.trunc((new Date()).getTime() / 1000),
                days: 0,
                hours: '00',
                minutes: '00',
                seconds: '00'
            }
        },

        mounted() {
            window.setInterval(() => {
                this.countdown();
            },1000);
        },

        methods: {
            countdown() {
                this.now = Math.trunc((new Date()).getTime() / 1000);

                this.days = Math.trunc((this.date - this.now) / 60 / 60 / 24);
                this.hours = Math.trunc((this.date - this.now) / 60 / 60) % 24;
                this.minutes = Math.trunc((this.date - this.now) / 60) % 60
                this.seconds = (this.date - this.now) % 60;
            }
        },

        filters: {
            twoDigits(value) {
                if(value.toString().length <= 1)
                {
                    return "0"+value.toString();
                }
                return value.toString();
            }
        }

    }
</script>