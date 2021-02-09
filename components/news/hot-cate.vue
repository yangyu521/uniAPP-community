<template>
	<view>
		
		<view class="flex align-center justify-between px-2">
			<text class="font-md">热门分类</text>
			<view class="flex align-center font animated" hover-class="jello" @click="openMore">
				更多<text class="iconfont icon-jinru"></text>
			</view>
		</view>
		
		<view class="flex align-center py-3 border-bottom">
			<view class="border rounded bg-light mx-1 px-2 animated" hover-class="jello" v-for="(item,index) in hotCate" :key="index" @click="openDetail(item)">
				{{item.name}}
			</view>
		
		</view>
			
			
	</view>
</template>

<script>
	export default {
		props:['hotCate'],
		methods:{
			openMore(){
				console.log(11111)
				uni.navigateTo({
					url:"../../pages/topic-nav/topic-nav"
				})
			},
			openDetail(e){
				console.log(e)
			}
		}
	}
</script>

<style>
</style>
