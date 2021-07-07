<template>
    <div class="h-full">
        Hello {{ user.name }}, welcome to {{ board.name }}

        <div class="h-full overflow-x-auto flex flex-nowrap">
            <div v-for="column in columns" :key="column.id" class="h-full bg-gray px-4 py-5 m-2 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md" style="min-width: 300px;">
                <h3>{{ column.name }}</h3>
                <div v-if="role.name === 'Owner' || role.name === 'Administrator'">
                    <button v-on:click="deleteColumn(column.id)" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">
                        X
                    </button>
                </div>
                <hr>
                <draggable
                    class="list-group"
                    :list="column.tasks"
                    group="people"
                    @change="event"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item min-w-full md:min-w-5 ">{{ index }} - {{ element.title }}</div>
                    </template>
                </draggable>
            </div>
                <div>
                    <vue-final-modal v-model="showCreateColumnModal" classes="modal-container" content-class="modal-content">
                        <div class="flex justify-center">
                            <div class="flex w-6/12 bg-gray px-4 py-5 mt-2 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                <form @submit.prevent="submit(showCreateColumnModal)" class="modal___content">
                                    <label for="name" class="ml-3 mr-2">Name : </label>
                                    <input type="text" id="name" v-model="createColumnForm.name" class="rounded-sm px-4 py-1 mt-3 mr-3 focus:outline-none bg-gray-100 " />
                                    <button type="submit" class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition'>Create</button>
                                </form>
                            </div>
                        </div>
                    </vue-final-modal>
                    <button @click="showCreateColumnModal = true" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ">Add a column</button>
                </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import { Inertia } from '@inertiajs/inertia'
    import { toRefs, reactive } from "vue";

    export default {
        props: {
            board: Object,
            role: Object,
            user: Object,
        },
        setup(props) {
            // add Create column/Delete Column/Update Column
            // add create task/delete task
            // add on change update of column
                // on 'move', 'added', 'removed'
            const state = reactive({
                columns: props.board.columns,
                loading: false,
                createColumnForm: {
                    name: null,
                    order: null,
                },
                showCreateColumnModal: false,
            })
            
            const event = (evt) => {
                console.log(state.columns)
                if(evt.moved) {
                    console.log(JSON.stringify(evt.moved))
                } else if(evt.added) {
                    console.log(JSON.stringify(evt.added))
                } else if(evt.removed) {
                    console.log(JSON.stringify(evt.removed))
                } else {
                    console.log(error)
                }
            }

            const submit = async () => {
                state.loading = true
                state.createColumnForm.order = state.columns.length + 1
                await axios.post('/board/' + props.board.id + '/column/store', state.createColumnForm)
                    .then(res => {
                        state.loading = false
                        state.columns.push(res.data)
                        state.showCreateColumnModal = false
                    })
            }

            const deleteColumn = async (column_id) => {
                confirm('Are you sure you want to delete this board?') 
                    ? Inertia.delete('/column/' + column_id + '/destroy', null, { preserveState: true })
                    : null
            }

            return { deleteColumn, submit, event, ...toRefs(state) }
        },
        methods: {
        },
        components: {
            draggable,
        },
    };

</script>