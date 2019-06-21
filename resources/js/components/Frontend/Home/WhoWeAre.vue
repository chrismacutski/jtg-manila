<template>
    <div class="jtg-planning-a-visit py-5" v-lazy:background-image="image">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 jtg-visit text-center p-5">
                    <h3 class="jtg-animate mb-2">ABOUT JTG MANILA CHURCH</h3>
                    <h6 class="mt-2 font-weight-bold jtg-animate">Christ is the VISION Making Disciples is our MISSION</h6>

                    <a href="/about/vision" class="btn btn-transparent py-3 px-4 jtg-animate">LEARN MORE</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'image'
        ]
    }
</script>