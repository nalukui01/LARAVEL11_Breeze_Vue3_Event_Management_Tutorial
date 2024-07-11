<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import moment from "moment";
import { ref } from 'vue';


/*

defineProps({
    events: {
        type: Array,
    },
});
*///pagination enabled props
defineProps({
  events: {
    type: Object,
    required: true, // Ensure events data is always provided
  },
  filters:{//for search
    type:Object,
    default:()=>({}),
  },
});
const form = useForm({});
/*const searchTerm = ref(filters.search || '');

const handleSearch = ()=>{
    Inertia.get(route('events.index')){search:searchTerm.value},{
        preserveState: true,
        preserveScroll: true,
    });
};

const handleSearch = () => {
    Inertia.get(route('events.index'), { search: searchTerm.value }, {
        preserveState: true,
        preserveScroll: true,
    });
};*/
const deleteEvent = (id) => {
    if (confirm("Are you sure you want to move this to trash")) {
        form.delete(route("event.delete", { id: id }), {
            preserveScroll: true,
            preserveState: true,
        });
    }
};

const formatDate = (date) => {
    return moment(date).format("MM/DD/YYYY hh:mm");
};

</script>

<template>
    <Head title="Event Management" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Event Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between">
                        <div class="p-6 text-gray-900">List of events</div>
                        <div class="my-auto px-5">
                            <form style="float:left;margin-right:100px;">
                                <input type="search" style="margin-right:10px;" name='search' id="search" placeholder="search here" v-model="searchTerm">
                                <button class="p-3 rounded my-auto text-white bg-green-500">Search</button>
                            </form>
                            <Link
                                :href="route('event.create')"
                                class="p-3 rounded my-auto text-white bg-blue-500"
                            >
                                Create Event
                            </Link>
                        </div>
                    </div>
                    <div class="flex flex-col p-6">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full py-2 sm:px-6 lg:px-8"
                            >
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border rounded text-left text-sm font-light text-surface dark:text-white"
                                    >
                                        <thead
                                            class="border-b border-neutral-200 font-medium dark:border-white/10"
                                        >
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-4"
                                                >
                                                    #
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-4"
                                                >
                                                    Event Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-4"
                                                >
                                                    Location
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-4"
                                                >
                                                    Start Date
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-4"
                                                >
                                                    End Date
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-4"
                                                >
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(event, index) in events.data"
                                                :key="event.id"
                                                class="border-b border-neutral-200 dark:border-white/10"
                                            >
                                                <td style="color:black"
                                                    class="whitespace-nowrap px-6 py-4"
                                                >
                                                    {{ (events.current_page -1)*events.per_page + index +1 }}
                                                </td>
                                                <td style="color:black"
                                                    class="whitespace-nowrap px-6 py-4"
                                                >
                                                    {{ event.name }}
                                                </td>
                                                <td style="color:black"
                                                    class="whitespace-nowrap px-6 py-4"
                                                >
                                                    {{ event.location }}
                                                </td>
                                                <td style="color:black"
                                                    class="whitespace-nowrap px-6 py-4"
                                                >
                                                    {{
                                                        formatDate(
                                                            event.from_datetime
                                                        )
                                                    }}
                                                </td>
                                                <td style="color:black"
                                                    class="whitespace-nowrap px-6 py-4"
                                                >
                                                    {{
                                                        formatDate(
                                                            event.to_datetime
                                                        )
                                                    }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-6 py-4"
                                                >
                                                    <Link
                                                        :href="
                                                            route(
                                                                'event.show',
                                                                [event.id]
                                                            )
                                                        "
                                                        class="p-3 rounded my-auto text-white bg-green-600"
                                                    >
                                                        View
                                                    </Link>
                                                    <Link
                                                        :href="
                                                            route(
                                                                'event.edit',
                                                                { id: event.id }
                                                            )
                                                        "
                                                        class="ml-2 p-3 rounded my-auto text-white bg-blue-500"
                                                    >
                                                        Edit
                                                    </Link>
                                                    <DangerButton
                                                        class="ml-2 py-3 rounded my-auto text-white bg-red-500"
                                                        @click="
                                                            deleteEvent(
                                                                event.id
                                                            )
                                                        "
                                                    >
                                                        Delete
                                                    </DangerButton>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-6">
                                        <template v-for="link in events.links" :key="link.url">
                                            <Link v-if="link.url" :href="link.url + '&search=' + searchTerm" v-html="link.label"
                                                class="px-2 py-1 border rounded mx-1"
                                                :class="{ 'bg-blue-500 text-white': link.active, 'text-gray-700': !link.active }" />
                                            <span v-else v-html="link.label"
                                                class="px-2 py-1 text-gray-500 mx-1"></span>
                                        </template>
                                    </div>
                                    <!-- 
                                    <div class="mt-6">
                                        <template v-for="link in events.links" :key="link.url">
                                            <Link v-if="link.url" :href="link.url" v-html="link.label"
                                                class="px-2 py-1 border rounded mx-1"
                                                :class="{ 'bg-blue-500 text-white': link.active, 'text-gray-700': !link.active }" />
                                            <span v-else v-html="link.label"
                                                class="px-2 py-1 text-gray-500 mx-1"></span>
                                        </template>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div>
                                     
                  <!--  <Bootstrap5Pagination
                                                    
                                                    :current-page="pagination.current_page"
                                                    :total-pages="pagination.last_page"
                                                    :data="events"
                                                     @pagination-change-page="handlePageChange"
                                                />-->
                </div>
                                        
        </div>
    </AuthenticatedLayout>
</template>