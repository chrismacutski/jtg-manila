<template>
    <div>
        <div  v-if="message.is_sending" :class="[messageClass, isSendingClass]" style="color: grey;">
            <span class="message-text">
                <b>{{ message.content}}</b>
            </span>
        </div>
        <div  v-else :class="[messageClass, isSendingClass]">
            <span class="message-text">
                <b>{{ message.content}}</b>
            </span>
            <!--<div class="d-flex justify-content-end p-0 mt-0 mb-0" v-if="message.is_sending">-->
                <!--<span class="small text-muted">Sending...</span>-->
            <!--</div>-->
            <div class="d-flex justify-content-end p-0 mt-0 mb-0" v-if="!message.is_sending && author == 'admin'">
                <small><span class="small">{{ message.sent_at | chatTime}}</span></small>
            </div>
        </div>
    </div>
</template>

<style>
    .message-text {
        /*border-radius: 30px;*/
        font-weight: 300;
        font-size: 14px;
        line-height: 1.4;
        white-space: pre-wrap;
        -webkit-font-smoothing: subpixel-antialiased
    }
</style>

<script>
    export default {
        props: ['message', 'author'],

        computed: {
            messageClass() {
                if (this.author == 'chatter') {
                    if (this.message.from == 'chatter') {
                        // return "alert alert-primary border-primary text-right text-dark";
                        return "chat-message-box sender";
                    } else {
                        return "chat-message-box receiver";
                        // return "alert alert-light border-dark text-dark";
                    }
                } else {
                    if (this.message.from == 'admin') {
                        // return "alert alert-primary border-primary text-right text-dark";
                        return "chat-message-box sender";
                    } else {
                        // return "alert alert-light border-dark text-dark";
                        return "chat-message-box receiver";
                    }
                }
            },
            isSendingClass() {
                if (this.message.is_sending) {
                    return "mb-0";
                }
            }
        },
        filters:{
            chatTime(value){
                return moment(value).calendar();
            }
        }
    }
</script>