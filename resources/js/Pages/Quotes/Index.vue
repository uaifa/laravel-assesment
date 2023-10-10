<script setup>
	import { ref } from 'vue'
	import {router, Link, useForm} from '@inertiajs/inertia-vue3'
	import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'

	let props = defineProps({
		quotes: Object,
		quotes_list: Object,
		limit: Number
	})
	let limit = ref(props.limit);
	const form = useForm({
	  limit: props.limit
	})

	const postForm = useForm({
	  quote: ''
	})

	function favorite(quote){
		postForm.quote = quote;
		postForm.post(route('quote.favorite'), {
			preserveScroll: true,
			limit: limit
		});
	}
	function onChangelimit(event){
		form.limit = event.target.value;
		form.get(route('quotes.index'),{
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
						Quotes list
					</h2>
				</div>

				<div class="col-auto">
					<Link :href="`/quotes/?limit=${limit}`" :only="['quotes_list']" class="px-4 py-1 text-sm bg-blue-200 rounded-full">
						Refresh
					</Link>
				</div>
			</div>
			<select id="limit" name="limit" v-model="limit" @change="onChangelimit($event)">
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="15">15</option>
				<option value="20">20</option>
				
			</select>
			<div class="quotes-list">
				<div class="border-b border-gray-200 shadow">
                <table class="table-auto ">
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
                    <tbody class="bg-white divide-y divide-gray-300">
                        <tr v-for="(quote, index) in quotes_list" :key="`quote_list__${index}`" class="whitespace-nowrap">
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ ++index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ quote.quote }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a type="button" class="px-4 py-1 text-sm bg-blue-200 rounded-full" @click="favorite(`${quote.quote}`)">Favorite</a>
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