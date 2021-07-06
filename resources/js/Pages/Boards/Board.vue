<template>
    <div>
        Hello Faudel!
        This is our board named {{ board.name }} {{ user.name }}
        <ul>
        <draggable 
            v-model="columns" 
            group="columns" 
            @start="drag=true" 
            @end="drag=false" 
            item-key="id">
            <template #item="{element}">
                    <li>{{element.name}}</li>
            </template>
        </draggable>
        </ul>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import { toRefs, reactive } from "vue";

    export default {
        props: {
            board: Object,
            permission: String,
            user: Object,
        },
        setup(props) {
            const state = reactive({
                columns: props.board.columns,
            })

            return { ...toRefs(state) };
        },
        methods: {
        },
        components: {
            draggable,
        },
    };

</script>