<template>
    <vue-navigation-bar :options="navbarOptions" />
</template>
<style lang="scss">
    .vnb {
        background-color: #000000 !important;
        .vnb__menu-options__option__link {
            color: #ffffff !important;
        }

        .vnb__collapse-button {
            background-color: #000000 !important;
        }
    }
</style>
<script>
    export default {
        props: ['title'],
        data () {
            return {
                navbarOptions: {
                    elementId: 'about-navbar',
                    isUsingVueRouter: false,
                    mobileBreakpoint: 992,
//                    brandImagePath: './',
                    collapseButtonImageOpen: '/images/menu-icon.png',
//                    collapseButtonImageClose: require('../src/assets/images/times.png'),
//                    showBrandImageInMobilePopup: true,
                    ariaLabelMainNav: 'About Navigation',
                    menuOptionsLeft: [
                        {
                            type: 'link',
                            text: this.title,
                            path: './vision'
                        }
                    ],
                    menuOptionsRight: [
                        {
                            type: 'link',
                            text: 'MORE',
                            class: 'button-red',
                            subMenuOptions: [
                                {
                                    type: 'link',
                                    text: 'OUR HISTORY',
                                    path: './history'
                                },
                                {
                                    type: 'link',
                                    text: 'MISSION AND VISION',
                                    path: './vision'
                                },
                                {
                                    type: 'link',
                                    text: 'OUR SENIOR PASTORS',
                                    path: './senior-pastors'
                                },
                                {
                                    type: 'link',
                                    text: 'LEADERSHIP',
                                    path: './leadership'
                                },
                                {
                                    type: 'link',
                                    text: 'DEPARTMENTS',
                                    path: './departments'
                                },
                                {
                                    type: 'link',
                                    text: 'MINISTRY',
                                    path: './ministries'
                                },
                                {
                                    type: 'link',
                                    text: 'REAL - MADE TEACHINGS',
                                    path: './real-made-teachings'
                                },
                                {
                                    type: 'link',
                                    text: 'WHAT WE BELIEVE',
                                    path: './what-we-believe'
                                },
                            ]
                        }
                    ]
                }
            }
        }
    }
</script>