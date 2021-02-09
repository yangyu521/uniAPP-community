<template>
	<view>
		<view class="py-2 flex align-center justify-center font-sm text-light-muted" v-if="shortTime">
			{{shortTime}}
		</view>
		<!-- 消息气泡 -->
		<view class="flex align-start p-2"
		      :style="isSelf ? 'flex-direction: row-reverse;' : ''">
			<image :src="item.avatar" mode="aspectFill" style="width: 100rpx;height: 100rpx;" class="rounded-circle"></image>
			<view class="bg-light p-2 rounded mx-2" style="max-width: 400rpx;">
				{{item.data}}
			</view>
		</view>
	</view>
</template>

<script>
	const uid = 1;
	import $T from "@/common/time.js"
	export default {
		props:{
			item:Object,
			index:Number,
			preTime:[Number,String]
		},
		computed:{
			//是否是用户本人
			isSelf(){
				return uid === this.item.user_id
			},
			shortTime(){
				return $T.getChatTime(this.item.create_time,this.preTime)
			}
		}
	}
</script>

<style>
</style>
