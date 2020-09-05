#include<bits/stdc++.h>
using namespace std;

struct node
{
	int key;
	struct node *left, *right;
};

struct node  *newNode (int item)
{
	struct node *new_node = (struct node *)malloc(sizeof(struct node));
new_node->key=item;
new_node->left= new_node->right=NULL;
return new_node;	
}

struct node *insert(struct node *node,int key)
{
	
	if(node == NULL)
	return newNode(key);
	if(key<node->key)
		node->left=insert(node->left,key);
	else if(node->key < key)
		node->right=insert(node->right,key);
	return node;

}
void inorder(struct node *root)
{
	if(root!=NULL)
	{
		inorder(root->left);
		cout<<root->key<<" ";
		inorder(root->right);
	}
}
int main()
{
	struct node *root =NULL;
	root=insert(root,5);
	insert(root,4);
	insert(root,3);
	insert(root,8);
	
	insert(root,7);
	inorder(root);

}