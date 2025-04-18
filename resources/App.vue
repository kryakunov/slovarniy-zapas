<template>
    <div><h1>hello</h1>
        <RepeatComponent :myVariable="parentVariable" />

    </div>
</template>

<script>
import RepeatComponent from './components/RepeatComponent.vue';
import NewComponent from './components/NewComponent.vue';

export default {
    components: {
        RepeatComponent,
        NewComponent,
    },
    data() {
        return {
            parentVariable: 'Привет, мир!',
        };
    },
};
</script>
