<template>
	<view>
	<view class="p-2 animated fast fadeIn">
		<!-- 头像昵称 | 关注按钮 -->
		<view class="flex align-center justify-between">
			<view class="flex align-center">
				<!-- 头像 -->
				<image :src="item.userpic" @click="openSpace" class="rounded-circle mr-2" style="width: 65rpx;height: 65rpx;"
				 lazy-load ></image>
				<!-- 昵称发布时间 -->
				<view>
					<view class="font" style="line-height: 1.5;">
						{{item.username}}
					</view>
					<text class="text-light-muted">{{item.newstime}}</text>
				</view>
			</view>
			<view v-if="!item.isFollow" class="flex align-center justify-center bg-main animated faster" hover-class="rubberBand" style="width: 90rpx;height: 50rpx;border-radius: 5rpx;color: #FFFFFF" @click="follow(index)">
				关注
			</view>
		</view>
	</view>
	<!-- 标题 -->
	<view class="p-2" @click="openDetail">
		{{item.title}}
	</view>
	<!-- 图片 -->
	<view>
		<slot>
		<image @click="openDetail" v-if="item.titlepic" :src="item.titlepic" style="width: 100%;height: 350rpx;" class="rounded p-1"></image>
		</slot>
	</view>
	<!-- 图标按钮 -->
	<view class="flex align-center">
		<!-- 顶 -->
		<view class="flex justify-center flex-1 animated" hover-class="rubberBand text-main" :class="item.support.type === 'support' ? 'support-active' : '' " @click="doSupport('support')">
			<text class="iconfont icon-dianzan2 mr-1"></text>
			<text>{{item.support.support_count>0 ? item.support.support_count : '顶'}}</text>
		</view>
		<!-- 踩 -->
		<view class="flex flex-1 justify-center animated" hover-class="rubberBand text-main" @click="doSupport('unsupport')" :class="item.support.type === 'unsupport' ? 'support-active' : '' ">
			<text class="iconfont icon-cai mr-1"></text>
			<text>{{item.support.unsupport_count>0 ? item.support.unsupport_count : '踩' }}</text>
		</view>
		<view class="flex-1 justify-center flex animated" hover-class="rubberBand" @click="doComment">
				<text class="iconfont icon-pinglun2 mr-1"></text>
			<text>{{item.comment_count>0 ? item.comment_count : '评论'}}</text>
		</view>
		<view class="flex-1 flex justify-center animated" hover-class="rubberBand" @click="doShare">
					<text class="iconfont icon-zhuanfa1 mr-1"></text>
			<text>{{item.share_num>0 ? item.share_num : '分享'}}</text>
		</view>
	</view>
	</view>
</template>

<script>
	export default{
		props:{
			item:Object,
			index:{
				type:Number,
				default:-1
			},
			isdetail:{
				type:Boolean,
				default:false
			}
		},
		methods:{
			openSpace(){
				uni.navigateTo({
					url:"/pages/user-space/user-space"
				})
			},
			follow(index){
				// 给父组件发送消息
				this.$emit("follow",index)
			},
			openDetail(){
				if(this.isdetail) return;
				uni.navigateTo({
					url:"../../pages/detail/detail?detail="+JSON.stringify(this.item)
				})
			},
			doSupport(type){
				this.$emit('doSupport',{
					type:type,
					index:this.index
				})
			},
			doComment(){
			    if(!this.isdetail){
					this.openDetail()
					return;
				}
				this.$emit('doComment')
			},
			doShare(){
				if(!this.isdetail){
					this.openDetail()
					return;
				}
				this.$emit('doShare')
				}
		}
	}
</script>

<style>
	.support-active{
		color: #FF4A6A;
	}
</style>
