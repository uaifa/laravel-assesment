<script setup>
	import {useForm} from '@inertiajs/inertia-vue3'
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'

	let props = defineProps({
		user: Object
	})
	const form = useForm({});
	
    function unfavorite(id){

		form.delete(route('favorites.destroy', id), {
			preserveScroll: true
		});
	}
</script>

<template>
	<BreezeAuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    			<div class="grid grid-rows-3 grid-flow-col gap-4">
    				<div class="col-auto">
    					<h2>
    						Favorite Quotes
    					</h2>
    				</div>
    			</div>
    	
    			<div class="quotes-list">
    				<div class="border-b border-gray-200 shadow">
                    <table class="divide-y divide-gray-300 ">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    ID
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Quote
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300" v-if="user && user.favorite_quotes">
                            <tr v-for="(quote, index) in user.favorite_quotes" :key="`quote_list__${index}`" class="whitespace-nowrap">
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ ++index }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ quote.quote }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" type="button" class="px-4 py-1 text-sm bg-blue-200 rounded-full" @click="unfavorite(`${quote.id}`)">Unfavorite</a>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
    			</div>
            </div>
		</div>
	</BreezeAuthenticatedLayout>
</template>