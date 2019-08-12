<template>
    <div class="container">
        <div class="navbar">
            <span>Laravel Test</span>
        </div>
        <div class="row justify-content-md-center">
            <category-rule></category-rule>
        </div>
    </div>
</template>
<script>
    import {Cartesian, Area} from 'laue'
    import CategoryRule from './components/CategoryRule.vue'

    export default {
        components: {
            LaCartesian: Cartesian,
            LaArea: Area,
            CategoryRule,
        },
        mounted() {

        },
        data() {
            return {

            }
        }
    }
</script>